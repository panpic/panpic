CREATE
-- ALTER
VIEW view_blog_services AS
SELECT a.blog_id, a.category_id, a.post_type, a.portfolio_year, a.date_add,  
	b.lang, b.slug, b.title, b.short, b.content, b.title_2, b.seo_title, b.seo_description, b.home_status, 
	i.path_image, i.path_image_thumb
FROM pp_blog AS a
JOIN pp_blog_translate AS b
ON a.blog_id = b.blog_id 
	AND a.post_type = 'S'
	-- AND a.category_id != 21
	-- AND a.post_type NOT IN ('P')
	AND a.avail = 1
LEFT JOIN pp_images AS i ON a.blog_id = i.object_id 
	AND i.image_type = 'S'