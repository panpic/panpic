CREATE 
-- ALTER
VIEW view_download AS
SELECT a.blog_id, a.category_id, a.post_type, a.date_add, a.hits,  
	b.lang, b.slug, b.title, b.title_2, b.short, b.seo_title, b.seo_description, b.home_status, 
	i.path_image, i.path_image_thumb
FROM pp_blog AS a
JOIN pp_blog_translate AS b
ON a.blog_id = b.blog_id 
	AND a.post_type = 'DL'  
	AND a.avail = 1
LEFT JOIN pp_images AS i ON a.blog_id = i.object_id 

