const sqlite3 = require('sqlite3').verbose();
const path = require('path');
const bcrypt = require('bcrypt');

const dbPath = path.resolve(__dirname, 'database.sqlite');
const db = new sqlite3.Database(dbPath);

const initDb = () => {
    db.serialize(() => {
        // Users Table for Admin Auth
        db.run(`CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE,
            password TEXT
        )`);

        // Insert default admin if not exists
        db.get("SELECT * FROM users WHERE username = 'admin'", async (err, row) => {
            if (!row) {
                const hashedPassword = await bcrypt.hash('admin123', 10);
                db.run("INSERT INTO users (username, password) VALUES (?, ?)", ['admin', hashedPassword]);
            }
        });

        // Drop the old content table if it exists
        db.run(`DROP TABLE IF EXISTS content`);

        // Content Table for general site copy (CMS)
        db.run(`CREATE TABLE content (
            key TEXT PRIMARY KEY,
            page TEXT,
            value TEXT,
            type TEXT
        )`);

        // Services and Testimonials Tables
        db.run(`CREATE TABLE IF NOT EXISTS services (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT,
            description TEXT,
            icon TEXT,
            link TEXT
        )`);

        db.run(`CREATE TABLE IF NOT EXISTS testimonials (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            author TEXT,
            role TEXT,
            text TEXT
        )`);

        // Initialize default content for Index Page
        const stmt = db.prepare("INSERT INTO content (key, page, value, type) VALUES (?, ?, ?, ?)");
        
        // Home Page (index)
        stmt.run('home_hero_subtitle', 'index', 'Sarahswati Agni', 'text');
        stmt.run('home_hero_title', 'index', 'Transform Your Hair. Heal Your Energy. Ignite Your Spirit.', 'text');
        stmt.run('home_hero_desc', 'index', 'Professional Dreadlocks Artist, Hypnotherapist, Breathwork Guide & Fire Dance Instructor.', 'textarea');
        stmt.run('home_intro_subtitle', 'index', 'The Signature Artistry', 'text');
        stmt.run('home_intro_title', 'index', 'Master Dreadlock Artist & Repair Specialist', 'text');
        stmt.run('home_intro_lead', 'index', '"Dreadlocks are not just a hairstyle; they are a crown of strength, patience, and identity. Each lock is sculpted with intention, precision, and respect for your hair\'s unique pattern."', 'textarea');
        
        // About Page
        stmt.run('about_hero_title', 'about', 'The Woman Behind the Craft', 'text');
        stmt.run('about_hero_subtitle', 'about', 'Artist, Healer, Guide, Spirit', 'text');
        stmt.run('about_intro_subtitle', 'about', 'A Vision of Transformation', 'text');
        stmt.run('about_intro_title', 'about', 'Merging Artistry with Inner Alignment', 'text');
        stmt.run('about_intro_lead', 'about', '"I believe that our outer form and our inner state are deeply interconnected. When we work on our crown, we are locking in intentions. When we breathe, we are releasing the past."', 'textarea');
        stmt.run('about_story_1', 'about', 'For over a decade, Sarahswati Agni has been navigating the intersection of physical styling and energetic alignment. Rooted in India and drawing inspiration from global tribal cultures, Bali wellness practices, and the transformational energy of Burning Man, she has cultivated a unique personal brand.', 'textarea');
        stmt.run('about_story_2', 'about', 'Her journey began with a deep appreciation for dreadlocks as natural sculptures. Over the years, this visual craft evolved. She realized that sitting for hours in a dreadlock chair is a deeply intimate, meditative process. Clients began sharing stories, crying, laughing, and releasing. This realization prompted her to pursue clinical hypnotherapy, breathwork training, and somatic release practices to support her clients holistically.', 'textarea');

        stmt.finalize();
    });
};

initDb();

module.exports = db;

