<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controllers Frontend
 * Last update 20 May 2025
 *
 * @package Frontend
 * @copyright PANPIC
 * @author contact@panpic.vn
 * @author pos: PHP Developer
 * @since 20 May 2025
 */
class Test extends FRONT_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('index_model');
        $this->load->library('blog_lib');
    }

    /**
     * Index
     */
    function index()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $link = "https://www.keyword-tools.org/en/google-ranking-live-check/?keyword=thiet%20ke%20web&domain=panpic.vn&searchengine=google.com&analysis=true";
        $test = file_get_contents($link);
        pre($test);

        $path_upload_html = $this->config->item("path_upload_html");

        $menu_mobile_html = $this->parser->parse('widget/menu-mobile.tpl', $this->_data, TRUE);
        file_put_contents($path_upload_html.'/menu_mobile.html', $menu_mobile_html);

        $menu_html = $this->parser->parse('widget/menu-pc.tpl', $this->_data, TRUE);
        file_put_contents($path_upload_html.'/menu.html', $menu_html);
    }

    function code_html(){
        $str = '<h2>Hướng dẫn sử dụng Bootstrap cho người mới</h2>

<p>Bootstrap l&agrave; một trong những framework CSS phổ biến nhất, gi&uacute;p bạn x&acirc;y dựng website responsive nhanh ch&oacute;ng v&agrave; dễ d&agrave;ng. Nếu bạn l&agrave; người mới bắt đầu, b&agrave;i viết n&agrave;y sẽ hướng dẫn từng bước c&aacute;ch sử dụng Bootstrap để tạo giao diện website chuy&ecirc;n nghiệp, đồng thời tối ưu h&oacute;a cho SEO.</p>

<h2>Bootstrap l&agrave; g&igrave;?</h2>

<p>Bootstrap l&agrave; một framework m&atilde; nguồn mở do Twitter ph&aacute;t triển, cung cấp c&aacute;c th&agrave;nh phần giao diện (UI) như n&uacute;t, menu điều hướng, form, v&agrave; hệ thống lưới (grid system) để x&acirc;y dựng website responsive. Với Bootstrap, bạn kh&ocirc;ng cần viết qu&aacute; nhiều CSS m&agrave; vẫn tạo được giao diện đẹp, tương th&iacute;ch tr&ecirc;n mọi thiết bị.</p>

<p><strong>Lợi &iacute;ch của Bootstrap</strong>:</p>

<ul>
    <li>Dễ sử dụng, ph&ugrave; hợp cho người mới bắt đầu.</li>
    <li>Cộng đồng lớn, t&agrave;i liệu phong ph&uacute;.</li>
    <li>Hỗ trợ responsive design, gi&uacute;p website th&acirc;n thiện với SEO.</li>
</ul>

<h2>Hướng dẫn c&agrave;i đặt Bootstrap</h2>

<p>Để bắt đầu với Bootstrap, bạn c&oacute; thể c&agrave;i đặt theo hai c&aacute;ch: sử dụng CDN hoặc tải file về dự &aacute;n.</p>

<h3>1. C&agrave;i đặt qua CDN</h3>

<p>Sử dụng CDN l&agrave; c&aacute;ch nhanh nhất để t&iacute;ch hợp Bootstrap. Chỉ cần th&ecirc;m c&aacute;c đoạn m&atilde; sau v&agrave;o phần <code><head> và <body></code> của file HTML:</p>

<pre>
<code>
<link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" rel="stylesheet" />

<!-- Thêm JavaScript của Bootstrap (đặt trước thẻ </body>) --> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</code>
</pre>

<h3>2. Tải file Bootstrap về dự &aacute;n</h3>

<ul>
    <li>Truy cập <a href="https://getbootstrap.com" rel="noopener noreferrer" target="_blank">trang ch&iacute;nh thức của Bootstrap</a> v&agrave; tải phi&ecirc;n bản mới nhất (hiện tại l&agrave; Bootstrap 5.3).</li>
    <li>Giải n&eacute;n v&agrave; th&ecirc;m file <code>bootstrap.min.css</code> v&agrave;o thư mục dự &aacute;n, sau đ&oacute; li&ecirc;n kết trong HTML:</li>
</ul>

<pre><code><link href="path/to/bootstrap.min.css" rel="stylesheet" /></code></pre>

<p><strong>Lưu &yacute;</strong>: Nếu muốn sử dụng c&aacute;c th&agrave;nh phần tương t&aacute;c như modal hoặc dropdown, bạn cần th&ecirc;m file JavaScript của Bootstrap.</p>

<h2>Sử dụng hệ thống lưới (Grid System) của Bootstrap</h2>

<p>Hệ thống lưới của Bootstrap l&agrave; c&ocirc;ng cụ mạnh mẽ để tạo bố cục responsive. N&oacute; dựa tr&ecirc;n 12 cột, cho ph&eacute;p bạn chia trang th&agrave;nh c&aacute;c phần linh hoạt.</p>

<h3>V&iacute; dụ: Tạo layout 2 cột</h3>

<p>Dưới đ&acirc;y l&agrave; c&aacute;ch tạo một layout với 2 cột, mỗi cột chiếm 6 cột trong lưới:</p>

<pre><code>
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <h2>Cột 1</h2>
      <p>Nội dung cột 1.</p>
    </div>
    <div class="col-md-6">
      <h2>Cột 2</h2>
      <p>Nội dung cột 2.</p>
    </div>
  </div>
</div>
</code></pre>

<p><strong>Giải th&iacute;ch</strong>:</p>

<ul>
    <li><code>container:</code> Tạo v&ugrave;ng chứa ch&iacute;nh, giữ nội dung ở giữa trang.</li>
    <li><code>row:</code> Tạo h&agrave;ng ngang để chứa c&aacute;c cột.</li>
    <li><code>col-md-6:</code> Chỉ định mỗi cột chiếm 6/12 chiều rộng tr&ecirc;n m&agrave;n h&igrave;nh vừa trở l&ecirc;n (md = medium).</li>
</ul>

<h3>T&ugrave;y chỉnh responsive</h3>

<p>Bootstrap cung cấp c&aacute;c class như <code>col-sm-*, col-md-*, col-lg-* </code>để điều chỉnh bố cục theo k&iacute;ch thước m&agrave;n h&igrave;nh (nhỏ, vừa, lớn). V&iacute; dụ:</p>

<ul>
    <li><code>col-sm-12 col-md-6 col-lg-4:</code> Cột chiếm to&agrave;n bộ chiều rộng tr&ecirc;n m&agrave;n h&igrave;nh nhỏ, 1/2 tr&ecirc;n m&agrave;n h&igrave;nh vừa, v&agrave; 1/3 tr&ecirc;n m&agrave;n h&igrave;nh lớn.</li>
</ul>

<h2>Sử dụng c&aacute;c th&agrave;nh phần UI của Bootstrap</h2>

<p>Bootstrap cung cấp nhiều th&agrave;nh phần UI sẵn c&oacute;, gi&uacute;p tiết kiệm thời gian thiết kế. Dưới đ&acirc;y l&agrave; một số th&agrave;nh phần phổ biến:</p>

<h3>1. N&uacute;t (Buttons)</h3>

<p>Tạo c&aacute;c n&uacute;t đẹp mắt với c&aacute;c class như <code>btn, btn-primary, btn-lg:</code></p>

<pre>
<code>
<button class="btn btn-primary">Nút chính</button>
<button class="btn btn-secondary btn-lg">Nút lớn</button>
</code>
</pre>

<h3>2. Thanh điều hướng (Navbar)</h3>

<p>Tạo menu điều hướng responsive:</p>

<pre><code>
<<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Logo</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#">Trang chủ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Giới thiệu</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
</code>
</pre>

<h3>3. Form</h3>

<p>Tạo form đăng nhập với c&aacute;c class như form-control:</p>

<pre>
<code>
<form>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" placeholder="name@example.com">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Mật khẩu</label>
    <input type="password" class="form-control" id="password">
  </div>
  <button type="submit" class="btn btn-primary">Đăng nhập</button>
</form>
</code>
</pre>

<h2>Tối ưu SEO với Bootstrap</h2>

<p>Bootstrap kh&ocirc;ng chỉ gi&uacute;p tạo giao diện đẹp m&agrave; c&ograve;n hỗ trợ SEO nếu sử dụng đ&uacute;ng c&aacute;ch:</p>

<ul>
    <li><strong>Responsive design</strong>: Hệ thống lưới v&agrave; c&aacute;c class responsive đảm bảo website hiển thị tốt tr&ecirc;n mọi thiết bị, một yếu tố quan trọng trong xếp hạng SEO của Google.</li>
    <li><strong>Tốc độ tải trang</strong>: Chỉ sử dụng c&aacute;c th&agrave;nh phần cần thiết của Bootstrap để giảm k&iacute;ch thước file CSS/JS. Bạn c&oacute; thể d&ugrave;ng c&ocirc;ng cụ như PurgeCSS để loại bỏ CSS kh&ocirc;ng d&ugrave;ng đến.</li>
    <li><strong>Cấu tr&uacute;c HTML r&otilde; r&agrave;ng</strong>: Sử dụng c&aacute;c thẻ ngữ nghĩa như
    <code><header>, <nav>, <main></code>kết hợp với Bootstrap để tăng khả năng thu thập dữ liệu của c&ocirc;ng cụ t&igrave;m kiếm.
    </li>
</ul>

<p><strong>Mẹo</strong>: Kiểm tra hiệu suất website bằng Google PageSpeed Insights sau khi t&iacute;ch hợp Bootstrap để đảm bảo tốc độ tải trang tối ưu.</p>

<h2>V&iacute; dụ: Tạo một trang web đơn giản với Bootstrap</h2>

<p>Dưới đ&acirc;y l&agrave; một mẫu HTML ho&agrave;n chỉnh sử dụng Bootstrap để tạo trang web cơ bản:</p>

<pre><code>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hướng dẫn sử dụng Bootstrap</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="#">MyWebsite</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="#">Trang chủ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Liên hệ</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Nội dung chính -->
  <div class="container my-5">
    <div class="row">
      <div class="col-md-6">
        <h1>Chào mừng đến với Bootstrap</h1>
        <p>Bắt đầu tạo website responsive ngay hôm nay!</p>
        <button class="btn btn-primary">Tìm hiểu thêm</button>
      </div>
      <div class="col-md-6">
        <img src="https://via.placeholder.com/400" alt="Hình ảnh website responsive" class="img-fluid">
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2025 MyWebsite. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</code>
</pre>

<h2>FAQ</h2>

<h3>1. Bootstrap c&oacute; miễn ph&iacute; kh&ocirc;ng?</h3>

<p>C&oacute;, Bootstrap l&agrave; m&atilde; nguồn mở v&agrave; ho&agrave;n to&agrave;n miễn ph&iacute; để sử dụng cho cả dự &aacute;n c&aacute; nh&acirc;n v&agrave; thương mại.</p>

<h3>2. Bootstrap c&oacute; ảnh hưởng đến SEO kh&ocirc;ng?</h3>

<p>Bootstrap hỗ trợ SEO tốt nếu bạn tối ưu h&oacute;a đ&uacute;ng c&aacute;ch, như giảm k&iacute;ch thước file CSS/JS v&agrave; đảm bảo website responsive.</p>

<h3>3. T&ocirc;i c&oacute; thể t&ugrave;y chỉnh Bootstrap kh&ocirc;ng?</h3>

<p>C&oacute;, bạn c&oacute; thể t&ugrave;y chỉnh Bootstrap bằng c&aacute;ch sử dụng SASS hoặc ghi đ&egrave; c&aacute;c class CSS để ph&ugrave; hợp với thiết kế của bạn.</p>

<h2><code>Kết luận</code></h2>

<p>Bootstrap l&agrave; c&ocirc;ng cụ l&yacute; tưởng cho người mới bắt đầu muốn x&acirc;y dựng website responsive nhanh ch&oacute;ng. Với hệ thống lưới mạnh mẽ, c&aacute;c th&agrave;nh phần UI sẵn c&oacute;, v&agrave; khả năng tối ưu SEO, Bootstrap gi&uacute;p bạn tiết kiệm thời gian m&agrave; vẫn tạo ra giao diện chuy&ecirc;n nghiệp. H&atilde;y thử &aacute;p dụng c&aacute;c bước trong b&agrave;i viết n&agrave;y v&agrave; bắt đầu dự &aacute;n web của bạn ngay h&ocirc;m nay!</p>
';

    echo $this->blog_lib->escape_code_blocks($str);

    }

    
}