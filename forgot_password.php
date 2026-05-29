<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>New Password | Curated Excellence</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=Montserrat:wght@300;400;500;600&display=swap');

        :root {
            --color-bg: #0a0a0a;
            --color-panel: #ffffff;
            --color-text: #1a1a1a;
            --color-text-muted: #666666;
            --color-accent: #c5a059;
            --color-border: #e0e0e0;
            --font-heading: 'Cormorant Garamond', serif;
            --font-body: 'Montserrat', sans-serif;
            --transition: all 0.3s ease;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--font-body);
            background-color: var(--color-bg);
            height: 100vh;
            overflow: hidden;
        }

        .login-container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        /* --- Image Panel --- */
        .image-panel {
            flex: 1;
            background-image: url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-panel::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .overlay-text {
            position: relative;
            z-index: 2;
            color: #ffffff;
            text-align: center;
            padding: 2rem;
        }

        .tag {
            font-size: 0.75rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--color-accent);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .overlay-text h1 {
            font-family: var(--font-heading);
            font-size: 3.5rem;
            font-weight: 300;
            line-height: 1.1;
            margin-bottom: 0.5rem;
        }

        .overlay-text h2 {
            font-family: var(--font-heading);
            font-size: 2rem;
            font-weight: 400;
            font-style: italic;
            margin-bottom: 1.5rem;
            color: #cccccc;
        }

        .overlay-text p {
            font-size: 0.9rem;
            line-height: 1.6;
            color: #d9d9d9;
            font-weight: 300;
        }

        /* --- Form Panel --- */
        .form-panel {
            flex: 1;
            background-color: var(--color-panel);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .form-content {
            width: 100%;
            max-width: 400px;
        }

        .form-content h1 {
            font-family: var(--font-heading);
            font-size: 2.5rem;
            font-weight: 400;
            margin-bottom: 0.5rem;
            color: var(--color-text);
        }

        .form-content > p {
            color: var(--color-text-muted);
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-size: 0.7rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-weight: 600;
            color: var(--color-text);
            margin-bottom: 0.5rem;
        }

        input[type="password"] {
            width: 100%;
            padding: 12px 0;
            border: none;
            border-bottom: 1px solid var(--color-border);
            background-color: transparent;
            font-family: var(--font-body);
            font-size: 1rem;
            color: var(--color-text);
            transition: var(--transition);
            outline: none;
            border-radius: 0;
        }

        input:focus {
            border-bottom-color: var(--color-text);
        }

        input::placeholder {
            color: #b3b3b3;
            font-weight: 300;
        }

        .password-requirements {
            font-size: 0.75rem;
            color: var(--color-text-muted);
            margin-top: 0.5rem;
            line-height: 1.4;
        }

        .btn-primary {
            width: 100%;
            padding: 14px;
            background-color: var(--color-text);
            color: #ffffff;
            border: none;
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary:hover {
            background-color: var(--color-accent);
            color: #ffffff;
        }

        .footer-text {
            margin-top: 2rem;
            font-size: 0.85rem;
            color: var(--color-text-muted);
            text-align: center;
        }

        .footer-text a {
            color: var(--color-text);
            text-decoration: none;
            font-weight: 500;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        /* --- Mobile --- */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            
            .image-panel {
                display: none;
            }
            
            .form-panel {
                height: 100vh;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Panel -->
        <div class="image-panel">
            <div class="overlay-text">
                <p class="tag">NEW SEASON</p>
                <h1>Curated Excellence</h1>
                <h2>PASTIMES</h2>
                <p>Empowering the next generation of fashion curators with surgical precision and artistic soul.</p>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="form-panel">
            <div class="form-content">
                <h1>Create Password</h1>
                <p>Enter your new password below.</p>

                <form method="POST" action="">
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" placeholder="Enter new password" name="new_password" required>
                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" placeholder="Confirm new password" name="confirm_password" required>
                    </div>

                    <p class="password-requirements">
                        Must be at least 8 characters with a number and symbol.
                    </p>

                    <button type="submit" name="update_password" class="btn-primary">
                        Update Password →
                    </button>
                </form>

                <p class="footer-text">
                    <a href="login.php">← Back to Sign In</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>