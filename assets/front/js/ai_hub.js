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

    // ========== FORM VALIDATION ==========
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
                return phoneRegex.test(cleaned) && (cleaned.length === 11 || cleaned.length === 12);
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

    // Clear error on input change
    // IMPORTANT: Chờ DOM load xong trước khi gọi addEventListener
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
            }
        });
    });

    function removeErrorFromField(inputElement) {
        const formGroup = inputElement.closest('.form-group');
        if (formGroup) {
            formGroup.classList.remove('error');
        }
    }

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

    function clearAllErrors() {
        Object.keys(formFields).forEach(fieldName => {
            const field = formFields[fieldName];
            const formGroup = field.input.closest('.form-group');
            if (formGroup) {
                formGroup.classList.remove('error');
            }
        });
    }

    function validateForm() {
        clearAllErrors();
        let isValid = true;

        Object.keys(formFields).forEach(fieldName => {
            const field = formFields[fieldName];
            const value = field.input.value;

            if (!field.validate(value)) {
                showError(fieldName);
                isValid = false;
            }
        });

        return isValid;
    }

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

    function validateAndSubmit(event) {
        event.preventDefault();

        if (!validateForm()) {
            console.log('❌ Form validation failed');
            return;
        }

        const formData = getFormData();
        console.log('✓ Form submitted successfully:', formData);

        // Show success message
        const successMsg = document.getElementById('successMessage');
        successMsg.classList.add('show');

        // Clear form
        document.getElementById('contactForm').reset();
        clearAllErrors();

        // Hide success message after 5 seconds
        setTimeout(() => {
            successMsg.classList.remove('show');
        }, 5000);

        // TODO: Send to server
        // Hiện tại chỉ log console, cần integrate với backend
        // Example:
        // fetch('/api/contact', {
        //     method: 'POST',
        //     headers: { 'Content-Type': 'application/json' },
        //     body: JSON.stringify(formData)
        // }).then(res => res.json()).catch(err => console.error(err));
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
