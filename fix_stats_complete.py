import re

file_path = r'f:\RPS Website\index.html'

# Read the file
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# Define the complete stats section CSS that should exist
stats_css = '''        .btn-secondary:hover {
            background: white;
            color: var(--primary);
        }

        /* Stats Section */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            max-width: 1200px;
            margin: -3rem auto 0;
            padding: 0 2rem;
            position: relative;
            z-index: 100;
        }

        .stat-card {
            background: rgb(255, 255, 255);
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-10px) scale(1.05);
            animation: glow 1.5s ease-in-out infinite alternate;
        }

        /* Individual card colors */
        .stat-card:nth-child(1):hover {
            box-shadow: 0 20px 60px rgba(59, 130, 246, 0.6);
            border: 2px solid #3b82f6;
        }

        .stat-card:nth-child(2):hover {
            box-shadow: 0 20px 60px rgba(16, 185, 129, 0.6);
            border: 2px solid #10b981;
        }

        .stat-card:nth-child(3):hover {
            box-shadow: 0 20px 60px rgba(245, 158, 11, 0.6);
            border: 2px solid #f59e0b;
        }

        .stat-card:nth-child(4):hover {
            box-shadow: 0 20px 60px rgba(239, 68, 68, 0.6);
            border: 2px solid #ef4444;
        }

        @keyframes glow {
            from {
                filter: brightness(1);
            }
            to {
                filter: brightness(1.2);
            }
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: var(--gray);
            font-size: 1rem;
        }'''

# Find and replace the section from .btn-secondary to .stat-label
# Pattern: from ".btn-secondary {" to the end of ".stat-label {"
pattern = r'(\.btn-secondary \{[^}]+\})\s*\.btn-secondary:hover.*?\.stat-label \{[^}]+\}'

replacement = stats_css

new_content = re.sub(pattern, replacement, content, flags=re.DOTALL)

if new_content != content:
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(new_content)
    print("Successfully fixed stats section CSS!")
else:
    print("Pattern not found, trying alternative...")

print("Done!")
