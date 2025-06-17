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
    function escape_code_blocks($content)
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


}