# Quick Guide: Adding PDF Files for Download

## What You Need to Do

1. **Prepare Your PDF Files**
   - Create or gather your class routine PDFs
   - Create or gather your syllabus PDFs

2. **Name Them Correctly**
   - For Class Routines:
     * `class-routine.pdf` (for "All Classes" option)
     * `routine-play-group.pdf`
     * `routine-nursery.pdf`
     * `routine-kg.pdf`
     * `routine-class-1.pdf`
     * `routine-class-2.pdf`
     * ... and so on up to `routine-class-10.pdf`

   - For Syllabuses:
     * `syllabus.pdf` (for "All Classes" option)
     * `syllabus-play-group.pdf`
     * `syllabus-nursery.pdf`
     * `syllabus-kg.pdf`
     * `syllabus-class-1.pdf`
     * ... and so on up to `syllabus-class-10.pdf`

3. **Place Them in the docs Folder**
   - Copy all PDF files to: `f:\RPS Website\docs\`

4. **Test**
   - Open your website
   - Go to Academic Programs page
   - Select a class
   - Click "Preview" or "Download"

## How to Create a PDF from the Template

### Option 1: Using the HTML Template
1. Open `docs/sample-routine-template.html` in a browser
2. Edit the content as needed
3. Press Ctrl+P (Print)
4. Choose "Save as PDF"
5. Save with the correct name (e.g., `routine-class-5.pdf`)
6. Move to the `docs` folder

### Option 2: Using Microsoft Word
1. Create your routine in Word
2. File → Save As → PDF
3. Name it correctly (e.g., `routine-class-5.pdf`)
4. Save to the `docs` folder

### Option 3: Using Google Docs
1. Create your routine in Google Docs
2. File → Download → PDF Document
3. Rename to correct format
4. Move to the `docs` folder

## Current Status

✅ Folder created: `f:\RPS Website\docs\`
✅ README guide created
✅ Sample template created
⏳ Waiting for you to add actual PDF files

## Example File List

Once you add your PDFs, your `docs` folder should look like:
```
docs/
├── README.md (guide)
├── sample-routine-template.html (template)
├── class-routine.pdf (YOUR FILE)
├── routine-class-1.pdf (YOUR FILE)
├── routine-class-2.pdf (YOUR FILE)
├── syllabus.pdf (YOUR FILE)
├── syllabus-class-1.pdf (YOUR FILE)
└── ... (more PDF files)
```

## The Code is Already Working!

The JavaScript in your `index.html` already handles:
- ✅ Detecting which class is selected
- ✅ Updating the download links automatically
- ✅ Preview button (opens in new tab)
- ✅ Download button (forces download)

You just need to add the PDF files!
