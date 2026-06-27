<section class="cta-final" id="contact">
    <div class="container">
        <h2>Sẵn sàng tăng tốc độ với AI?</h2>
        <p>Nhận tư vấn miễn phí 30 phút, không có commitment</p>

        <div style="background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 8px; max-width: 500px; margin: 2rem auto;">
            <form id="contactForm" method="post" onsubmit="validateAndSubmit(event)">
                <div class="success-message" id="successMessage">
                    ✓ Cảm ơn! Chúng tôi sẽ liên hệ bạn trong 24 giờ.
                </div>

                <div class="form-group">
                    <input type="text" id="companyName" placeholder="Tên công ty/Họ tên" style="width: 100%;">
                    <div class="error-message">Vui lòng nhập tên (ít nhất 3 ký tự)</div>
                </div>

                <div class="form-group">
                    <input type="email" id="email" placeholder="Email" style="width: 100%;">
                    <div class="error-message">Email không hợp lệ</div>
                </div>

                <div class="form-group">
                    <input type="tel" id="phone" placeholder="Số điện thoại (VD: 0986973897)" style="width: 100%;">
                    <div class="error-message">Số điện thoại phải có 10-11 số</div>
                </div>

                <div class="form-group">
                    <select id="service" style="width: 100%;">
                        <option value="">-- Chọn dịch vụ quan tâm --</option>
                        <option value="writing">AI Content Writing</option>
                        <option value="chatbot">AI Customer Support</option>
                        <option value="both">Cả hai</option>
                        <option value="other">Khác</option>
                    </select>
                    <div class="error-message">Vui lòng chọn dịch vụ</div>
                </div>

                <div class="form-group">
                    <textarea id="message" placeholder="Mô tả nhanh nhu cầu của bạn" rows="3" style="width: 100%;"></textarea>
                    <div class="error-message">Vui lòng nhập mô tả (ít nhất 10 ký tự)</div>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Gửi yêu cầu tư vấn</button>
            </form>
        </div>

        <p style="margin-top: 2rem; color: #ccc; font-size: 0.9rem;">
            📞 Hoặc liên hệ trực tiếp: <strong>0986 97 38 97</strong> (<a href="https://zalo.me/0986973897" title="Zalo Panpic" style="color: var(--primary);">Zalo</a>) <br>
            📧 Email: <strong>contact@panpic.vn</strong>
        </p>
    </div>
</section>
