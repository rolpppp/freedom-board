# Freedom Board

A simple PHP/MySQL discussion board web application.

**Live Preview:** [http://3.27.76.187](http://3.27.76.187)

---

## Features

- **User Registration & Login** — Secure authentication using PHP sessions and `password_hash`/`password_verify`
- **Post Messages** — Authenticated users can post messages to the board
- **Threaded Replies** — Users can reply to any post
- **Delete Own Posts** — Users can delete their own posts and replies, with a confirmation dialog
- **Search** — Filter posts by content or author username
- **Pagination** — Board paginates at 5 posts per page
- **Live Updates** — Board auto-refreshes when a new post is detected (polls every 5 seconds)

---

## Tech Stack

- **Backend:** PHP 8, PDO (MySQL)
- **Database:** MySQL (Live deployment: via AWS RDS)
- **Server:** Apache (Live deployment: via AWS EC2)
- **Auth:** PHP Sessions

---

## Project Structure

```
freedom-board/
├── public/
│   ├── index.php       # Entry point
│   └── style.css
├── src/
│   ├── db.php          # Database connection
│   ├── auth/
│   │   ├── login.php
│   │   ├── register.php
│   │   ├── logout.php
│   │   └── auth_check.php
│   └── posts/
│       ├── board.php   # Main board view
│       ├── actions.php # Post/delete handler
│       └── poll.php    # Live update endpoint
├── freedom_board.sql   # Database schema + seed data
└── .env                # DB credentials (not committed)
```

---

## Local Setup

**Requirements:** PHP 8+, MySQL

1. Clone the repo and create a `.env` file at the project root:
   ```
   DB_HOST=localhost
   DB_NAME=freedom_board
   DB_USER=root
   DB_PASS=your_password
   ```

2. Import the database schema:
   ```bash
   mysql -u root -p freedom_board < freedom_board.sql
   ```

3. Start the dev server:
   ```bash
   php -S localhost:8080 router.php
   ```

4. Visit [http://localhost:8080](http://localhost:8080)

---

## Database Schema

**`users`** — `id`, `username`, `password` (hashed)

**`posts`** — `id`, `user_id`, `content`, `parent_id` (null = top-level post, set = reply), `time_posted`
