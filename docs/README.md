# PDF File Structure for RPS Website

## Overview
The website automatically handles PDF downloads for Class Routines and Syllabuses based on the selected class.

## Folder Structure
```
f:\RPS Website\
└── docs\
    ├── class-routine.pdf          (General/All classes routine)
    ├── routine-play-group.pdf     (Play Group routine)
    ├── routine-nursery.pdf        (Nursery routine)
    ├── routine-kg.pdf             (KG routine)
    ├── routine-class-1.pdf        (Class 1 routine)
    ├── routine-class-2.pdf        (Class 2 routine)
    ├── routine-class-3.pdf        (Class 3 routine)
    ├── routine-class-4.pdf        (Class 4 routine)
    ├── routine-class-5.pdf        (Class 5 routine)
    ├── routine-class-6.pdf        (Class 6 routine)
    ├── routine-class-7.pdf        (Class 7 routine)
    ├── routine-class-8.pdf        (Class 8 routine)
    ├── routine-class-9.pdf        (Class 9 routine)
    ├── routine-class-10.pdf       (Class 10 routine)
    ├── syllabus.pdf               (General/All classes syllabus)
    ├── syllabus-play-group.pdf    (Play Group syllabus)
    ├── syllabus-nursery.pdf       (Nursery syllabus)
    ├── syllabus-kg.pdf            (KG syllabus)
    ├── syllabus-class-1.pdf       (Class 1 syllabus)
    ├── syllabus-class-2.pdf       (Class 2 syllabus)
    ├── syllabus-class-3.pdf       (Class 3 syllabus)
    ├── syllabus-class-4.pdf       (Class 4 syllabus)
    ├── syllabus-class-5.pdf       (Class 5 syllabus)
    ├── syllabus-class-6.pdf       (Class 6 syllabus)
    ├── syllabus-class-7.pdf       (Class 7 syllabus)
    ├── syllabus-class-8.pdf       (Class 8 syllabus)
    ├── syllabus-class-9.pdf       (Class 9 syllabus)
    └── syllabus-class-10.pdf      (Class 10 syllabus)
```

## How It Works

### 1. Class Selection
When a user selects a class from the dropdown (e.g., "Class 5"), the JavaScript automatically:
- Converts the class name to a URL-friendly format (e.g., "Class 5" → "class-5")
- Updates the download links to point to the correct PDF file

### 2. Download Buttons
There are two buttons for each document type:
- **Preview**: Opens the PDF in a new browser tab
- **Download**: Forces the browser to download the PDF file

### 3. File Naming Convention
- Use lowercase letters
- Replace spaces with hyphens (-)
- Example: "Play Group" → "play-group"
- Example: "Class 10" → "class-10"

## Adding Your PDF Files

### Option 1: Create Sample PDFs (for testing)
You can create simple text files and convert them to PDF, or use any PDF you have.

### Option 2: Use Your Actual School Documents
1. Prepare your class routine PDFs
2. Name them according to the convention above
3. Place them in the `docs` folder

## Example: Adding a Class 5 Routine

1. Create or prepare your Class 5 routine PDF
2. Rename it to: `routine-class-5.pdf`
3. Copy it to: `f:\RPS Website\docs\routine-class-5.pdf`
4. Done! The website will automatically link to it when "Class 5" is selected

## Testing

1. Open `index.html` in a browser
2. Navigate to the "Academic Programs" page
3. Select a class from the dropdown
4. Click "Preview" to view the PDF in browser
5. Click "Download" to download the PDF file

## Notes

- If a specific class PDF is not found, the browser will show a 404 error
- Always include a general `class-routine.pdf` and `syllabus.pdf` for the "All Classes" option
- PDF files should be reasonably sized (recommended: under 5MB each)
- Ensure PDF files are not password-protected for easy access
