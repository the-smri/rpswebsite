// API Base URL
const API_BASE = window.location.origin + '/api';

// Enhanced login function with API integration
async function handleLogin() {
    const role = document.getElementById('loginRole').value;
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;

    try {
        const response = await fetch(API_BASE + '/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=login&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
        });

        const result = await response.json();

        if (result.status === 'success') {
            document.getElementById('mainContent').style.display = 'none';
            document.querySelector('header').style.display = 'none';
            document.querySelector('footer').style.display = 'none';
            closeLoginModal();

            document.getElementById('dashboardArea').style.display = 'block';
            document.getElementById(role + 'Dashboard').style.display = 'block';

            document.getElementById('loginEmail').value = '';
            document.getElementById('loginPassword').value = '';

            alert('✅ Login successful!');
        } else {
            alert('❌ ' + result.message);
        }
    } catch (error) {
        console.error('Login error:', error);
        alert('❌ Login failed. Please try again.');
    }
}

// Enhanced result search with API
async function searchResult() {
    const id = document.getElementById('resStudentId').value.trim();
    const year = document.getElementById('resYear').value;
    const exam = document.getElementById('resExam').value;
    const out = document.getElementById('resultOutput');

    if (!id) {
        alert('Please enter Student ID');
        return;
    }

    try {
        const response = await fetch(API_BASE + '/results', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=search_result&student_id=${encodeURIComponent(id)}&year=${encodeURIComponent(year)}&exam_type=${encodeURIComponent(exam)}`
        });

        const result = await response.json();

        if (result.status === 'success') {
            renderApiResult(result);
        } else {
            out.innerHTML = '<div class="result-card"><p style="color:var(--gray)">' + result.message + '</p></div>';
        }
    } catch (error) {
        console.error('Result search error:', error);
        out.innerHTML = '<div class="result-card"><p style="color:var(--gray)">Error searching result. Please try again.</p></div>';
    }
}

// Enhanced admission submission
async function submitAdmission() {
    const studentName = document.getElementById('studentName').value;
    const dob = document.getElementById('studentDOB').value;
    const studentClass = document.getElementById('studentClass').value;
    const fatherName = document.getElementById('fatherName').value;
    const motherName = document.getElementById('motherName').value;
    const contactNumber = document.getElementById('contactNumber').value;
    const parentEmail = document.getElementById('parentEmail').value;

    if (!studentName) {
        alert('❌ Please fill in the student name!');
        return;
    }

    try {
        const response = await fetch(API_BASE + '/admissions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=submit_admission&student_name=${encodeURIComponent(studentName)}&date_of_birth=${encodeURIComponent(dob)}&class_applying=${encodeURIComponent(studentClass)}&father_name=${encodeURIComponent(fatherName)}&mother_name=${encodeURIComponent(motherName)}&contact_number=${encodeURIComponent(contactNumber)}&email=${encodeURIComponent(parentEmail)}`
        });

        const result = await response.json();

        if (result.status === 'success') {
            alert('✅ ' + result.message);
            closeAdmissionForm();
            resetAdmissionForm();
        } else {
            alert('❌ ' + result.message);
        }
    } catch (error) {
        console.error('Admission submission error:', error);
        alert('❌ Failed to submit application. Please try again.');
    }
}

// Enhanced logout function
async function logout() {
    try {
        await fetch(API_BASE + '/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=logout'
        });
    } catch (error) {
        console.error('Logout error:', error);
    } finally {
        document.getElementById('dashboardArea').style.display = 'none';
        document.querySelectorAll('#dashboardArea > div').forEach(div => {
            div.style.display = 'none';
        });

        document.getElementById('mainContent').style.display = 'block';
        document.querySelector('header').style.display = 'block';
        document.querySelector('footer').style.display = 'block';

        showPageDirect('home');
        alert('✅ Logged out successfully!');
    }
}

// Function to render API result
function renderApiResult(apiResult) {
    const out = document.getElementById('resultOutput');
    const data = apiResult.student_info;
    const subjects = apiResult.subjects;

    let totalObtained = 0;
    let totalMax = 0;

    const rows = subjects.map(s => {
        const obtained = s.total;
        totalObtained += obtained;
        totalMax += s.max;
        const percent = (obtained / s.max) * 100;
        const g = gradeForPercent(percent);
        return `<tr>
            <td><strong>${s.name}</strong></td>
            <td>${s.theory || 0}</td>
            <td>${s.practical || '-'}</td>
            <td>${obtained}/${s.max}</td>
            <td><span class="grade-badge ${g.class}">${s.grade}</span></td>
        </tr>`;
    }).join('');

    const percentage = totalMax ? ((totalObtained / totalMax) * 100) : 0;
    const overallGrade = gradeForPercent(percentage).grade;

    const resultHtml = `
        <div class="result-card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
                <div>
                    <h3>${data.exam}</h3>
                    <p style="color:var(--gray)">${data.name} | ID: ${data.student_id} | Class ${data.class} - Section ${data.section}</p>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:2rem; font-weight:bold; color:var(--primary)">${percentage.toFixed(2)}%</div>
                    <div style="color:var(--gray)">Overall: ${overallGrade}</div>
                </div>
            </div>

            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Theory</th>
                            <th>Practical</th>
                            <th>Total</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${rows}
                    </tbody>
                </table>
            </div>

            <div style="margin-top:1.5rem; display:flex; gap:1rem; justify-content:flex-end;">
                <button class="btn btn-secondary" onclick="printResult('${data.student_id}')">Print</button>
                <button class="btn btn-primary" onclick="downloadResult('${data.student_id}','${data.exam.replace(/\s+/g, '_')}')">Download</button>
            </div>
        </div>`;

    out.innerHTML = resultHtml;
}

// Helper function to reset admission form
function resetAdmissionForm() {
    document.getElementById('studentName').value = '';
    document.getElementById('studentDOB').value = '';
    document.getElementById('studentClass').value = 'Play Group';
    document.getElementById('fatherName').value = '';
    document.getElementById('motherName').value = '';
    document.getElementById('contactNumber').value = '';
    document.getElementById('parentEmail').value = '';
}
