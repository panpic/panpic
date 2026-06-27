<!-- ========== PRICING ========== -->
<section class="section" id="pricing">
    <h2 class="section-title">Bảng giá</h2>
    <p class="section-subtitle">Flexible packages cho SME & Enterprise</p>

    <div class="pricing-tabs">
        <button class="tab-btn active" onclick="switchPricing('writing')">AI Writing</button>
        <button class="tab-btn" onclick="switchPricing('chatbot')">AI Chatbot</button>
    </div>

    <!-- Writing Pricing -->
    <div id="writing-pricing" class="pricing-grid" style="display: grid;">
        <div class="pricing-card">
            <div class="badge">Cho Startup</div>
            <h3>Nhúng AI viết</h3>
            <p>Implement & tuning cơ bản</p>
            <div class="price">3-5 triệu</div>
            <div class="price-note">Setup fee (1 lần)</div>
            <ul class="pricing-features">
                <li>Tích hợp vào website/CMS</li>
                <li>Tuning prompt cơ bản</li>
                <li>Training 1 lần</li>
                <li>Support 2 tuần đầu</li>
            </ul>
            <button class="btn btn-secondary" onclick="scrollToContact()" style="width: 100%; color: var(--dark); border-color: var(--text-light);">Liên hệ</button>
        </div>

        <div class="pricing-card featured">
            <div class="badge">Được khuyên</div>
            <h3>AI Content Strategy</h3>
            <p>Full service + ongoing support</p>
            <div class="price">1-2 triệu</div>
            <div class="price-note">+ Setup 3-5 triệu/tháng</div>
            <ul class="pricing-features">
                <li>Setup + tuning advanced</li>
                <li>Monthly strategy consulting</li>
                <li>Prompt optimization</li>
                <li>Performance monitoring</li>
                <li>Priority support 24/7</li>
            </ul>
            <button class="btn btn-primary" onclick="scrollToContact()" style="width: 100%;">Yêu cầu demo</button>
        </div>

        <div class="pricing-card">
            <div class="badge">Cho Enterprise</div>
            <h3>Custom Solution</h3>
            <p>Giải pháp tùy chỉnh đầy đủ</p>
            <div class="price">Tuỳ</div>
            <div class="price-note">Quote sau tư vấn</div>
            <ul class="pricing-features">
                <li>Fine-tuning model riêng</li>
                <li>Integration phức tạp</li>
                <li>Dedicated account manager</li>
                <li>Custom analytics</li>
                <li>Full SLA guarantee</li>
            </ul>
            <button class="btn btn-secondary" onclick="scrollToContact()" style="width: 100%; color: var(--dark); border-color: var(--text-light);">Tư vấn</button>
        </div>
    </div>

    <!-- Chatbot Pricing -->
    <div id="chatbot-pricing" class="pricing-grid" style="display: none;">
        <div class="pricing-card">
            <div class="badge">Cho SME</div>
            <h3>Chatbot Basic</h3>
            <p>Support tự động 24/7</p>
            <div class="price">4.5 triệu</div>
            <div class="price-note">/tháng</div>
            <ul class="pricing-features">
                <li>Live chat trên website</li>
                <li>Training FAQ cơ bản</li>
                <li>100-500 cuộc chat/ngày</li>
                <li>Basic analytics</li>
                <li>Bi-weekly tuning</li>
            </ul>
            <button class="btn btn-secondary" onclick="scrollToContact()" style="width: 100%; color: var(--dark); border-color: var(--text-light);">Yêu cầu demo</button>
        </div>

        <div class="pricing-card featured">
            <div class="badge">Phổ biến</div>
            <h3>Chatbot Plus</h3>
            <p>Support nâng cao + analytics</p>
            <div class="price">8-10 triệu</div>
            <div class="price-note">/tháng</div>
            <ul class="pricing-features">
                <li>Unlimited conversations</li>
                <li>Advanced training</li>
                <li>Ticket routing</li>
                <li>Analytics & insights</li>
                <li>Weekly optimization</li>
                <li>Multi-channel support</li>
            </ul>
            <button class="btn btn-primary" onclick="scrollToContact()" style="width: 100%;">Liên hệ tư vấn</button>
        </div>

        <div class="pricing-card">
            <div class="badge">Enterprise</div>
            <h3>Chatbot Custom</h3>
            <p>Giải pháp toàn diện</p>
            <div class="price">10-12 triệu</div>
            <div class="price-note">/tháng+</div>
            <ul class="pricing-features">
                <li>Tất cả tính năng Plus</li>
                <li>Custom integration</li>
                <li>Dedicated support team</li>
                <li>Daily optimization</li>
                <li>SLA guarantee</li>
                <li>Advanced NLP tuning</li>
            </ul>
            <button class="btn btn-secondary" onclick="scrollToContact()" style="width: 100%; color: var(--dark); border-color: var(--text-light);">Tư vấn</button>
        </div>
    </div>

    <p class="mt-3" style="text-align: center; color: var(--text-light);">
        <strong>💡 Ghi chú:</strong> Khách hàng trả riêng phí API (OpenAI/Claude) theo usage thực tế (~500k-3M/tháng tuỳ volume)
    </p>
</section>
