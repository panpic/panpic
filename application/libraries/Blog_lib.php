<?php

Class Blog_lib
{
    public $CI;

    function __construct()
    {
        $this->CI = & get_instance();
    }

    /**
     * Escape các ký tự đặc biệt trong <code>…</code> và <pre><code>…</code></pre>
     * mà KHÔNG giữ lại thuộc tính class.
     */
    function escape_code_blocks_v1($content)
    {
        $placeholders = [];
        $i = 0;

        /* 1) Xử lý <pre><code>…</code></pre> trước – gắn placeholder   */
        $content = preg_replace_callback(
            '#<pre>\s*<code(?:\s+class="[^"]*")?>(.*?)</code>\s*</pre>#is',
            function ($m) use (&$placeholders, &$i) {
                $escaped = htmlspecialchars($m[1], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                $key = "{{CODEBLOCK_$i}}";
                $placeholders[$key] = "<pre><code>{$escaped}</code></pre>";
                $i++;
                return $key;
            },
            $content
        );

        /* 2) Xử lý <code>…</code> còn lại (không nằm trong <pre>)      */
        $content = preg_replace_callback(
            '#<code(?:\s+class="[^"]*")?>(.*?)</code>#is',
            function ($m) {
                $escaped = htmlspecialchars($m[1], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                return "<code>{$escaped}</code>";
            },
            $content
        );

        /* 3) Thay thế placeholder bằng mã đã escape                   */
        foreach ($placeholders as $key => $block) {
            $content = str_replace($key, $block, $content);
        }

        return $content;
    }

    function escape_code_blocks_v2($content)
    {
        $placeholders = [];
        $i = 0;

        // 1) Xử lý <pre><code>…</code></pre> – escape nhưng không dùng nl2br
        $content = preg_replace_callback(
            '#<pre>\s*<code(?:\s+class="[^"]*")?>(.*?)</code>\s*</pre>#is',
            function ($m) use (&$placeholders, &$i) {
                $escaped = htmlspecialchars($m[1], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                $key = "{{CODEBLOCK_$i}}";
                $placeholders[$key] = "<pre><code>{$escaped}</code></pre>";
                $i++;
                return $key;
            },
            $content
        );

        // 2) Xử lý <code>…</code> còn lại – escape + giữ xuống dòng
        $content = preg_replace_callback(
            '#<code(?:\s+class="[^"]*")?>(.*?)</code>#is',
            function ($m) {
                $escaped = htmlspecialchars($m[1], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                $escaped = nl2br($escaped); // giữ xuống dòng
                return "<code>{$escaped}</code>";
            },
            $content
        );

        // 3) Thay thế placeholder bằng đoạn <pre><code> đã escape
        foreach ($placeholders as $key => $block) {
            $content = str_replace($key, $block, $content);
        }

        return $content;
    }

    function escape_code_blocks_v3($content)
    {
        $placeholders = [];
        $i = 0;

        // 1. Xử lý <pre><code> — KHÔNG dùng nl2br (đã giữ dòng)
        $content = preg_replace_callback(
            '#<pre>\s*<code(\s+class="[^"]*")?>([\s\S]*?)</code>\s*</pre>#i',
            function ($m) use (&$placeholders, &$i) {
                $classAttr = $m[1] ?? '';
                $code = $m[2];
                $escaped = htmlspecialchars($code, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                $key = "{{CODEBLOCK_PRE_$i}}";
                $placeholders[$key] = "<pre><code{$classAttr}>{$escaped}</code></pre>";
                $i++;
                return $key;
            },
            $content
        );

        // 2. Xử lý <blockquote><code> — CÓ dùng nl2br để giữ dòng
        $content = preg_replace_callback(
            '#<blockquote>\s*<code(\s+class="[^"]*")?>([\s\S]*?)</code>\s*</blockquote>#i',
            function ($m) use (&$placeholders, &$i) {
                $classAttr = $m[1] ?? '';
                $code = $m[2];
                $escaped = nl2br(htmlspecialchars($code, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
                $key = "{{CODEBLOCK_BQ_$i}}";
                $placeholders[$key] = "<blockquote><code{$classAttr}>{$escaped}</code></blockquote>";
                $i++;
                return $key;
            },
            $content
        );

        // 3. Xử lý inline <code> — không dùng nl2br
        $content = preg_replace_callback(
            '#<code(\s+class="[^"]*")?>(.*?)</code>#is',
            function ($m) {
                $classAttr = $m[1] ?? '';
                $code = $m[2];
                $escaped = htmlspecialchars($code, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                return "<code{$classAttr}>{$escaped}</code>";
            },
            $content
        );

        // 4. Gắn lại các placeholder
        foreach ($placeholders as $key => $block) {
            $content = str_replace($key, $block, $content);
        }

        return $content;
    }

    function escape_code_blocks($content, $defaultLang = 'php')
    {
        $placeholders = [];
        $i = 0;

        // 1. <pre><code>...</code></pre>
        $content = preg_replace_callback(
            '#<pre>\s*<code(?P<class>\s+class="[^"]*")?>(?P<code>[\s\S]*?)</code>\s*</pre>#i',
            function ($m) use (&$placeholders, &$i, $defaultLang) {
                $classAttr = $m['class'] ?? '';
                if (empty($classAttr)) {
                    $classAttr = ' class="language-' . $defaultLang . '"';
                }

                $code = $m['code'];
                $escaped = htmlspecialchars($code, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                $key = "{{CODEBLOCK_PRE_$i}}";
                $placeholders[$key] = "<pre><code{$classAttr}>{$escaped}</code></pre>";
                $i++;
                return $key;
            },
            $content
        );

        // 2. <blockquote><code>...</code></blockquote> (có nl2br)
        $content = preg_replace_callback(
            '#<blockquote>\s*<code(?P<class>\s+class="[^"]*")?>(?P<code>[\s\S]*?)</code>\s*</blockquote>#i',
            function ($m) use (&$placeholders, &$i, $defaultLang) {
                $classAttr = $m['class'] ?? '';
                if (empty($classAttr)) {
                    $classAttr = ' class="language-' . $defaultLang . '"';
                }

                $code = $m['code'];
                $escaped = nl2br(htmlspecialchars($code, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
                $key = "{{CODEBLOCK_BQ_$i}}";
                $placeholders[$key] = "<blockquote><code{$classAttr}>{$escaped}</code></blockquote>";
                $i++;
                return $key;
            },
            $content
        );

        // 3. inline <code>...</code> (giữ nguyên class nếu có, không nl2br)
        $content = preg_replace_callback(
            '#<code(?P<class>\s+class="[^"]*")?>(?P<code>.*?)</code>#is',
            function ($m) use ($defaultLang) {
                $classAttr = $m['class'] ?? '';
                if (empty($classAttr)) {
                    $classAttr = ' class="language-' . $defaultLang . '"';
                }

                $code = $m['code'];
                $escaped = htmlspecialchars($code, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                return "<code{$classAttr}>{$escaped}</code>";
            },
            $content
        );

        // 4. Thay thế placeholder
        foreach ($placeholders as $key => $block) {
            $content = str_replace($key, $block, $content);
        }

        return $content;
    }

}