import re

file_path = r'f:\RPS Website\index.html'

# Read the file
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# The CSS to insert after .btn-primary {
missing_css = '''
        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-secondary:hover {
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
'''

# Find .btn-primary { and insert after its closing }
pattern = r'(\.btn-primary \{[^}]+\})\s*\.stat-card:hover'

replacement = r'\1' + missing_css + '\n        .stat-card:hover'

new_content = re.sub(pattern, replacement, content, flags=re.DOTALL)

if new_content != content:
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(new_content)
    print("Successfully added missing CSS!")
else:
    print("Could not find pattern")

print("Done!")
