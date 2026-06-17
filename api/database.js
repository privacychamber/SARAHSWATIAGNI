const { Pool } = require('pg');
const bcrypt = require('bcrypt');

const pool = new Pool({
  connectionString: process.env.POSTGRES_URL || process.env.DATABASE_URL,
  ssl: {
    rejectUnauthorized: false
  }
});

const initDb = async () => {
    try {
        // Users Table for Admin Auth
        await pool.query(`CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            username TEXT UNIQUE,
            password TEXT
        )`);

        // Insert default admin if not exists
        const userRes = await pool.query("SELECT * FROM users WHERE username = 'admin'");
        if (userRes.rows.length === 0) {
            const hashedPassword = await bcrypt.hash('admin123', 10);
            await pool.query("INSERT INTO users (username, password) VALUES ($1, $2)", ['admin', hashedPassword]);
        }

        // Content Table for general site copy (CMS)
        await pool.query(`CREATE TABLE IF NOT EXISTS content (
            key TEXT PRIMARY KEY,
            page TEXT,
            value TEXT,
            type TEXT
        )`);

        // Services and Testimonials Tables
        await pool.query(`CREATE TABLE IF NOT EXISTS services (
            id SERIAL PRIMARY KEY,
            title TEXT,
            description TEXT,
            icon TEXT,
            link TEXT
        )`);

        await pool.query(`CREATE TABLE IF NOT EXISTS testimonials (
            id SERIAL PRIMARY KEY,
            author TEXT,
            role TEXT,
            text TEXT
        )`);

        // Initialize default content for Index Page
        const defaultContent = [
            ['home_hero_subtitle', 'index', 'Sarahswati Agni', 'text'],
            ['home_hero_title', 'index', 'Transform Your Hair. Heal Your Energy. Ignite Your Spirit.', 'text'],
            ['home_hero_desc', 'index', 'Professional Dreadlocks Artist, Hypnotherapist, Breathwork Guide & Fire Dance Instructor.', 'textarea'],
            ['home_intro_subtitle', 'index', 'The Signature Artistry', 'text'],
            ['home_intro_title', 'index', 'Master Dreadlock Artist & Repair Specialist', 'text'],
            ['home_intro_lead', 'index', '"Dreadlocks are not just a hairstyle; they are a crown of strength, patience, and identity. Each lock is sculpted with intention, precision, and respect for your hair\'s unique pattern."', 'textarea'],
            ['about_hero_title', 'about', 'The Woman Behind the Craft', 'text'],
            ['about_hero_subtitle', 'about', 'Artist, Healer, Guide, Spirit', 'text'],
            ['about_intro_subtitle', 'about', 'A Vision of Transformation', 'text'],
            ['about_intro_title', 'about', 'Merging Artistry with Inner Alignment', 'text'],
            ['about_intro_lead', 'about', '"I believe that our outer form and our inner state are deeply interconnected. When we work on our crown, we are locking in intentions. When we breathe, we are releasing the past."', 'textarea'],
            ['about_story_1', 'about', 'For over a decade, Sarahswati Agni has been navigating the intersection of physical styling and energetic alignment. Rooted in India and drawing inspiration from global tribal cultures, Bali wellness practices, and the transformational energy of Burning Man, she has cultivated a unique personal brand.', 'textarea'],
            ['about_story_2', 'about', 'Her journey began with a deep appreciation for dreadlocks as natural sculptures. Over the years, this visual craft evolved. She realized that sitting for hours in a dreadlock chair is a deeply intimate, meditative process. Clients began sharing stories, crying, laughing, and releasing. This realization prompted her to pursue clinical hypnotherapy, breathwork training, and somatic release practices to support her clients holistically.', 'textarea']
        ];

        for (const item of defaultContent) {
            await pool.query("INSERT INTO content (key, page, value, type) VALUES ($1, $2, $3, $4) ON CONFLICT DO NOTHING", item);
        }

    } catch (err) {
        console.error("Database initialization error:", err);
    }
};

initDb();

module.exports = pool;
