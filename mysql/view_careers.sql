CREATE 
-- ALTER
VIEW view_careers AS
SELECT a.blog_id, a.category_id, a.post_type, a.date_add, 
	b.lang, b.slug, b.title, b.short, b.content, b.seo_title, b.seo_description, b.home_status
FROM pp_blog AS a
JOIN pp_blog_translate AS b
ON a.blog_id = b.blog_id 
	AND a.post_type = 'R'
	AND a.avail = 1
