const express = require('express');
const cors = require('cors');
const path = require('path');
const db = require('./database');
const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');
const multer = require('multer');
const { put } = require('@vercel/blob');

const app = express();
const JWT_SECRET = process.env.JWT_SECRET || 'supersecretkey_sarahagni';
const upload = multer({ storage: multer.memoryStorage() });

app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// --- Database Init Route ---
app.get('/api/init', async (req, res) => {
    try {
        // Users Table for Admin Auth
        await db.query(`CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            username TEXT UNIQUE,
            password TEXT
        )`);

        const userRes = await db.query("SELECT * FROM users WHERE username = 'admin'");
        if (userRes.rows.length === 0) {
            const hashedPassword = await bcrypt.hash('admin123', 10);
            await db.query("INSERT INTO users (username, password) VALUES ($1, $2)", ['admin', hashedPassword]);
        }

        await db.query(`CREATE TABLE IF NOT EXISTS content (
            key TEXT PRIMARY KEY,
            page TEXT,
            value TEXT,
            type TEXT
        )`);

        await db.query(`CREATE TABLE IF NOT EXISTS services (
            id SERIAL PRIMARY KEY,
            title TEXT,
            description TEXT,
            icon TEXT,
            link TEXT
        )`);

        await db.query(`CREATE TABLE IF NOT EXISTS testimonials (
            id SERIAL PRIMARY KEY,
            author TEXT,
            role TEXT,
            text TEXT
        )`);

        const defaultContent = [
            ['home_hero_subtitle', 'index', 'Sarahswati Agni', 'text'],
            ['home_hero_title', 'index', 'Transform Your Hair. Heal Your Energy. Ignite Your Spirit.', 'text'],
            ['home_hero_desc', 'index', 'Professional Dreadlocks Artist, Hypnotherapist, Breathwork Guide & Fire Dance Instructor.', 'textarea'],
            ['home_intro_subtitle', 'index', 'The Signature Artistry', 'text'],
            ['home_intro_title', 'index', 'Master Dreadlock Artist & Repair Specialist', 'text'],
            ['home_hero_lead', 'index', '"Dreadlocks are not just a hairstyle; they are a crown of strength, patience, and identity. Each lock is sculpted with intention, precision, and respect for your hair\'s unique pattern."', 'textarea'],
            ['home_hero_image', 'index', '/assets/images/hero_dreadlocks.png', 'image'],
            ['home_split_image', 'index', '/assets/images/sarah_profile.png', 'image'],
            
            ['about_hero_title', 'about', 'The Woman Behind the Craft', 'text'],
            ['about_hero_subtitle', 'about', 'Artist, Healer, Guide, Spirit', 'text'],
            ['about_intro_subtitle', 'about', 'A Vision of Transformation', 'text'],
            ['about_intro_title', 'about', 'Merging Artistry with Inner Alignment', 'text'],
            ['about_intro_lead', 'about', '"I believe that our outer form and our inner state are deeply interconnected. When we work on our crown, we are locking in intentions. When we breathe, we are releasing the past."', 'textarea'],
            ['about_hero_image', 'about', '/assets/img/about-hero.jpg', 'image'],
            
            ['gallery_title', 'gallery', 'Portfolio & Artistry', 'text'],
            ['gallery_subtitle', 'gallery', 'A collection of transformations', 'text'],

            ['contact_title', 'contact', 'Connect with Sarah', 'text'],
            ['contact_subtitle', 'contact', 'Book your transformation', 'text'],
            ['contact_email', 'contact', 'booking@sarahagni.com', 'text']
        ];

        for (const item of defaultContent) {
            await db.query("INSERT INTO content (key, page, value, type) VALUES ($1, $2, $3, $4) ON CONFLICT DO NOTHING", item);
        }

        res.json({ success: true, message: "Database initialized successfully!" });
    } catch (err) {
        res.status(500).json({ error: err.message, stack: err.stack });
    }
});

// --- API Routes for Frontend ---

app.get('/api/content', async (req, res) => {
    try {
        const result = await db.query("SELECT * FROM content");
        const content = {};
        result.rows.forEach(row => {
            content[row.key] = row.value;
        });
        res.json(content);
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

app.get('/api/services', async (req, res) => {
    try {
        const result = await db.query("SELECT * FROM services");
        res.json(result.rows);
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

app.get('/api/testimonials', async (req, res) => {
    try {
        const result = await db.query("SELECT * FROM testimonials");
        res.json(result.rows);
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// --- Admin Authentication ---

app.post('/api/admin/login', async (req, res) => {
    const { username, password } = req.body;
    try {
        const result = await db.query("SELECT * FROM users WHERE username = $1", [username]);
        const user = result.rows[0];
        if (!user) return res.status(401).json({ error: "Invalid credentials" });

        const match = await bcrypt.compare(password, user.password);
        if (match) {
            const token = jwt.sign({ id: user.id, username: user.username }, JWT_SECRET, { expiresIn: '1h' });
            res.json({ token });
        } else {
            res.status(401).json({ error: "Invalid credentials" });
        }
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// Middleware to protect routes
const authenticateToken = (req, res, next) => {
    const authHeader = req.headers['authorization'];
    const token = authHeader && authHeader.split(' ')[1];
    
    if (token == null) return res.sendStatus(401);

    jwt.verify(token, JWT_SECRET, (err, user) => {
        if (err) return res.sendStatus(403);
        req.user = user;
        next();
    });
};

// --- Protected Admin Routes ---

app.get('/api/admin/content', authenticateToken, async (req, res) => {
    try {
        const result = await db.query("SELECT * FROM content");
        res.json(result.rows);
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

app.post('/api/admin/content', authenticateToken, async (req, res) => {
    const { key, value } = req.body;
    try {
        await db.query("INSERT INTO content (key, value) VALUES ($1, $2) ON CONFLICT (key) DO UPDATE SET value = EXCLUDED.value", [key, value]);
        res.json({ success: true, key, value });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

app.post('/api/upload', authenticateToken, upload.single('image'), async (req, res) => {
    try {
        if (!req.file) return res.status(400).json({ error: "No image provided" });
        const blob = await put(req.file.originalname, req.file.buffer, { access: 'public' });
        res.json({ url: blob.url });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

app.post('/api/admin/services', authenticateToken, async (req, res) => {
    const { title, description, icon, link } = req.body;
    try {
        const result = await db.query("INSERT INTO services (title, description, icon, link) VALUES ($1, $2, $3, $4) RETURNING id", [title, description, icon, link]);
        res.json({ success: true, id: result.rows[0].id });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

app.post('/api/admin/testimonials', authenticateToken, async (req, res) => {
    const { author, role, text } = req.body;
    try {
        const result = await db.query("INSERT INTO testimonials (author, role, text) VALUES ($1, $2, $3) RETURNING id", [author, role, text]);
        res.json({ success: true, id: result.rows[0].id });
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// Export the app for Vercel Serverless
module.exports = app;
