-- CREATE
ALTER
VIEW view_blog AS
SELECT a.blog_id, a.category_id, a.post_type, a.date_add, a.last_update, a.hits,
	b.lang, b.slug, b.title, b.short, b.content, b.seo_title, b.seo_description, b.home_status, 
	i.image_type, i.path_image, i.path_image_thumb, c.cat_name, c.cat_slug
FROM pp_blog AS a
JOIN pp_blog_translate AS b
ON a.blog_id = b.blog_id 
	AND a.post_type = 'B'
	-- AND a.category_id != 21
	-- AND a.post_type NOT IN ('B')
	AND a.avail = 1
JOIN view_category AS c ON a.category_id = c.post_cat_id	
LEFT JOIN pp_images AS i ON a.blog_id = i.object_id AND i.image_type = 'B'
	-- AND i.image_type = 'B'