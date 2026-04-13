/**
 * USeP OSAS Sports Unit - Student Athlete Registration Validation
 */

function validateStudentAthleteForm(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
    // Clear previous errors
    clearErrors();
    
    let isValid = true;
    let errors = [];
    
    // Student ID validation
    const studentId = formData.get('student_id');
    if (!studentId || studentId.trim() === '') {
        errors.push('Student ID is required');
        isValid = false;
    } else if (studentId.length < 3) {
        errors.push('Student ID must be at least 3 characters');
        isValid = false;
    }
    
    // Full Name validation
    const fullName = formData.get('full_name');
    if (!fullName || fullName.trim() === '') {
        errors.push('Full Name is required');
        isValid = false;
    } else if (fullName.length < 2) {
        errors.push('Full Name must be at least 2 characters');
        isValid = false;
    }
    
    // Email validation
    const email = formData.get('email');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email || email.trim() === '') {
        errors.push('Email is required');
        isValid = false;
    } else if (!emailRegex.test(email)) {
        errors.push('Please enter a valid email address');
        isValid = false;
    }
    
    // Status validation
    const status = formData.get('status');
    if (!status || status === '') {
        errors.push('Please select your status');
        isValid = false;
    }
    
    // Sport validation
    const sport = formData.get('sport');
    if (!sport || sport === '') {
        errors.push('Please select a sport');
        isValid = false;
    }
    
    // Campus validation
    const campus = formData.get('campus');
    if (!campus || campus === '') {
        errors.push('Please select a campus');
        isValid = false;
    }
    
    // Password validation
    const password = formData.get('password');
    const passwordConfirmation = formData.get('password_confirmation');
    if (!password || password.trim() === '') {
        errors.push('Password is required');
        isValid = false;
    } else if (password.length < 8) {
        errors.push('Password must be at least 8 characters');
        isValid = false;
    }
    
    if (password !== passwordConfirmation) {
        errors.push('Passwords do not match');
        isValid = false;
    }
    
    // Document validation
    const document = formData.get('document');
    if (!document || document.size === 0) {
        errors.push('Please upload a verification document');
        isValid = false;
    } else {
        // Check file size (2MB max)
        const maxSize = 2 * 1024 * 1024; // 2MB in bytes
        if (document.size > maxSize) {
            errors.push('Document size must be less than 2MB');
            isValid = false;
        }
        
        // Check file type
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(document.type)) {
            errors.push('Document must be PDF, JPG, or PNG format');
            isValid = false;
        }
    }
    
    // Display errors if any
    if (!isValid) {
        displayErrors(errors);
        hideLoadingModal();
        return false;
    }
    
    // If validation passes, submit the form
    form.submit();
    return true;
}

function displayErrors(errors) {
    let errorHtml = '<div class="error-message"><ul style="margin: 0; padding-left: 20px;">';
    
    errors.forEach(error => {
        errorHtml += `<li>${error}</li>`;
    });
    
    errorHtml += '</ul></div>';
    
    // Insert error message at the top of the form
    const form = document.querySelector('form');
    form.insertAdjacentHTML('afterbegin', errorHtml);
}

function clearErrors() {
    // Remove any existing error messages
    const existingErrors = document.querySelectorAll('.error-message');
    existingErrors.forEach(error => error.remove());
}

// Export for global access
window.validateStudentAthleteForm = validateStudentAthleteForm;
