CREATE
-- ALTER
VIEW view_blog_history AS
SELECT a.blog_id, a.category_id, a.post_type, a.date_add, a.portfolio_year, a.home_status, a.hits,   
	b.lang, b.slug, b.title, b.short, b.content, b.seo_title, b.seo_description, 
	i.path_image, i.path_image_thumb
FROM pp_blog AS a
JOIN pp_blog_translate AS b
ON a.blog_id = b.blog_id 
	AND a.post_type = 'HS'
	AND a.avail = 1
LEFT JOIN pp_images AS i ON a.blog_id = i.object_id 
