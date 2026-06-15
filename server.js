const express = require('express');
const cors = require('cors');
const path = require('path');
const db = require('./database');
const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');

const app = express();
const PORT = process.env.PORT || 3000;
const JWT_SECRET = 'supersecretkey_sarahagni'; // In production, use env var

app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Serve static frontend files
app.use(express.static(path.join(__dirname)));

// --- API Routes for Frontend ---

app.get('/api/content', (req, res) => {
    db.all("SELECT * FROM content", [], (err, rows) => {
        if (err) return res.status(500).json({ error: err.message });
        const content = {};
        rows.forEach(row => {
            content[row.key] = row.value;
        });
        res.json(content);
    });
});

app.get('/api/services', (req, res) => {
    db.all("SELECT * FROM services", [], (err, rows) => {
        if (err) return res.status(500).json({ error: err.message });
        res.json(rows);
    });
});

app.get('/api/testimonials', (req, res) => {
    db.all("SELECT * FROM testimonials", [], (err, rows) => {
        if (err) return res.status(500).json({ error: err.message });
        res.json(rows);
    });
});

// --- Admin Authentication ---

app.post('/api/admin/login', (req, res) => {
    const { username, password } = req.body;
    db.get("SELECT * FROM users WHERE username = ?", [username], async (err, user) => {
        if (err) return res.status(500).json({ error: err.message });
        if (!user) return res.status(401).json({ error: "Invalid credentials" });

        const match = await bcrypt.compare(password, user.password);
        if (match) {
            const token = jwt.sign({ id: user.id, username: user.username }, JWT_SECRET, { expiresIn: '1h' });
            res.json({ token });
        } else {
            res.status(401).json({ error: "Invalid credentials" });
        }
    });
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

app.get('/api/admin/content', authenticateToken, (req, res) => {
    db.all("SELECT * FROM content", [], (err, rows) => {
        if (err) return res.status(500).json({ error: err.message });
        res.json(rows);
    });
});

app.post('/api/admin/content', authenticateToken, (req, res) => {
    const { key, value } = req.body;
    db.run("INSERT OR REPLACE INTO content (key, value) VALUES (?, ?)", [key, value], function(err) {
        if (err) return res.status(500).json({ error: err.message });
        res.json({ success: true, key, value });
    });
});

app.post('/api/admin/services', authenticateToken, (req, res) => {
    const { title, description, icon, link } = req.body;
    db.run("INSERT INTO services (title, description, icon, link) VALUES (?, ?, ?, ?)", [title, description, icon, link], function(err) {
        if (err) return res.status(500).json({ error: err.message });
        res.json({ success: true, id: this.lastID });
    });
});

app.post('/api/admin/testimonials', authenticateToken, (req, res) => {
    const { author, role, text } = req.body;
    db.run("INSERT INTO testimonials (author, role, text) VALUES (?, ?, ?)", [author, role, text], function(err) {
        if (err) return res.status(500).json({ error: err.message });
        res.json({ success: true, id: this.lastID });
    });
});

// Start the server
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
