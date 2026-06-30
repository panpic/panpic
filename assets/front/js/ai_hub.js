// Smooth scroll
    function scrollToSection(sectionId) {
        const element = document.getElementById(sectionId);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
        }
    }

    function scrollToContact() {
        const contact = document.getElementById('contact');
        contact.scrollIntoView({ behavior: 'smooth' });
    }

    // Pricing tabs
    function switchPricing(type) {
        document.getElementById('writing-pricing').style.display = type === 'writing' ? 'grid' : 'none';
        document.getElementById('chatbot-pricing').style.display = type === 'chatbot' ? 'grid' : 'none';

        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
    }

    // FAQ toggle
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', function() {
            this.parentElement.classList.toggle('active');
        });
    });


    // Định nghĩa các field và rules validate
const formFields = {
    companyName: {
        input: document.getElementById('companyName'),
        validate: (value) => {
            const trimmed = value.trim();
            return trimmed.length >= 3;
        },
        errorMsg: 'Vui lòng nhập tên (ít nhất 3 ký tự)'
    },
    email: {
        input: document.getElementById('email'),
        validate: (value) => {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(value.trim());
        },
        errorMsg: 'Email không hợp lệ'
    },
    phone: {
        input: document.getElementById('phone'),
        validate: (value) => {
            const phoneRegex = /^(0|\+84)[0-9]{9,10}$/;
            const cleaned = value.replace(/[^\d+]/g, '');
            return phoneRegex.test(cleaned) && (cleaned.length === 10 || cleaned.length === 12);
        },
        errorMsg: 'Số điện thoại phải có 10-11 số (VD: 0986973897)'
    },
    service: {
        input: document.getElementById('service'),
        validate: (value) => {
            return value !== '' && value !== null;
        },
        errorMsg: 'Vui lòng chọn dịch vụ'
    },
    message: {
        input: document.getElementById('message'),
        validate: (value) => {
            return value.trim().length >= 10;
        },
        errorMsg: 'Vui lòng nhập mô tả (ít nhất 10 ký tự)'
    }
};

/**
 * Setup: Clear error khi user chỉnh sửa input
 * Auto-remove red border & error message
 *
 * IMPORTANT: Phải chờ DOM load xong trước khi gọi addEventListener
 */
document.addEventListener('DOMContentLoaded', function() {
    Object.keys(formFields).forEach(fieldName => {
        const field = formFields[fieldName];

        // Check nếu element tồn tại
        if (field.input) {
            field.input.addEventListener('input', function() {
                removeErrorFromField(field.input);
            });
            field.input.addEventListener('change', function() {
                removeErrorFromField(field.input);
            });
        } else {
            console.warn(`⚠️ Element with ID '${fieldName}' not found`);
        }
    });
});

/**
 * Xóa error class khỏi field khi user bắt đầu chỉnh sửa
 * @param {HTMLElement} inputElement - Input element
 */
function removeErrorFromField(inputElement) {
    const formGroup = inputElement.closest('.form-group');
    if (formGroup) {
        formGroup.classList.remove('error');
    }
}

/**
 * Hiển thị error message cho field
 * @param {string} fieldName - Tên field (ví dụ: 'email', 'phone')
 */
function showError(fieldName) {
    const field = formFields[fieldName];
    const formGroup = field.input.closest('.form-group');
    if (formGroup) {
        formGroup.classList.add('error');
        const errorMsg = formGroup.querySelector('.error-message');
        if (errorMsg) {
            errorMsg.textContent = field.errorMsg;
        }
    }
}

/**
 * Clear tất cả error trên form
 */
function clearAllErrors() {
    Object.keys(formFields).forEach(fieldName => {
        const field = formFields[fieldName];
        const formGroup = field.input.closest('.form-group');
        if (formGroup) {
            formGroup.classList.remove('error');
        }
    });
}

/**
 * Validate toàn bộ form
 * @returns {boolean} true nếu form hợp lệ, false nếu có lỗi
 */
function validateForm() {
    clearAllErrors();
    let isValid = true;

    // Kiểm tra từng field
    Object.keys(formFields).forEach(fieldName => {
        const field = formFields[fieldName];
        const value = field.input.value;

        // Nếu validate() trả về false → show error
        if (!field.validate(value)) {
            showError(fieldName);
            isValid = false;
        }
    });

    return isValid;
}

/**
 * Lấy dữ liệu từ form
 * @returns {object} Object chứa tất cả dữ liệu form
 */
function getFormData() {
    return {
        companyName: formFields.companyName.input.value.trim(),
        email: formFields.email.input.value.trim(),
        phone: formFields.phone.input.value.trim(),
        service: formFields.service.input.value,
        message: formFields.message.input.value.trim(),
        submittedAt: new Date().toLocaleString('vi-VN')
    };
}

/**
 * Show success message
 */
function showSuccessMessage() {
    const successMsg = document.getElementById('successMessage');
    if (successMsg) {
        successMsg.classList.add('show');

        // Auto-hide sau 5 giây
        setTimeout(() => {
            successMsg.classList.remove('show');
        }, 5000);
    }
}

/**
 * Main handler: Validate + Submit form
 * @param {Event} event - Form submit event
 */
function validateAndSubmit(event) {
    event.preventDefault();

    // Bước 1: Validate form
    if (!validateForm()) {
        console.log('❌ Form có lỗi, vui lòng kiểm tra lại');
        return;
    }

    // Bước 2: Lấy dữ liệu form
    const formData = getFormData();
    console.log('✓ Form validate thành công:', formData);

    // Bước 3: Show success message
    showSuccessMessage();

    // Bước 4: Clear form
    document.getElementById('contactForm').reset();
    clearAllErrors();

    // Bước 5: Gửi data tới server (TODO)
    sendFormDataToServer(formData);
}

/**
 * Gửi dữ liệu form tới backend via AJAX
 *
 * @param {object} formData - Object chứa dữ liệu form
 */
function sendFormDataToServer(formData) {
    // ========== OPTION 1: Gửi tới CodeIgniter controller ==========
    fetch('/contact/submit-ai-hub', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            console.log('✓ Success:', data.message);
            console.log('Consultation ID:', data.data.consultation_id);

            // Optional: Thêm success notification
            // alert('Tư vấn đã gửi! Chúng tôi sẽ liên hệ bạn trong 24 giờ.');
        } else {
            console.error('❌ Error:', data.message);
            console.error('Errors:', data.data);
            alert('Có lỗi: ' + data.message);
        }
    })
    .catch(err => {
        console.error('❌ Network error:', err);
        alert('Lỗi kết nối, vui lòng thử lại');
    });

    /* ========== OPTION 2: Gửi tới Laravel (nếu sau này bạn chuyển) ==========
    fetch('/api/contact/submit', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content
        },
        body: JSON.stringify(formData)
    })
    .then(res => res.json())
    .then(data => { ... })
    */

    /* ========== OPTION 3: Dùng Formspree (third-party) ==========
    // Setup: https://formspree.io
    fetch('https://formspree.io/f/YOUR_FORM_ID', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    })
    .then(res => res.json())
    .then(data => { ... })
    */
}
