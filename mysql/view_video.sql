CREATE
-- ALTER
VIEW view_video AS
SELECT b.blog_id, a.category_id, a.post_type, a.date_add, 
	b.lang, b.slug, b.title, b.short, b.content, b.seo_title, b.seo_description, b.home_status, 
	i.path_image, i.path_image_thumb
FROM pp_blog AS a
JOIN pp_blog_translate AS b 
ON a.blog_id = b.blog_id 
	AND a.post_type = 'B' AND a.category_id = 14
	AND a.avail = 1
LEFT JOIN pp_images AS i ON a.blog_id = i.object_id 

/*
SELECT b.blog_id, a.category_id, a.date_add, 
b.title, b.short, b.content, b.seo_title, b.seo_description, b.home_status, 
d.cat_name, i.path_image, i.path_image_thumb 
FROM pp_blog AS a JOIN pp_blog_translate AS b ON a.blog_id = b.blog_id AND a.avail = 1
LEFT JOIN view_category AS d ON a.category_id = d.post_cat_id 
LEFT JOIN pp_images AS i ON a.blog_id = i.object_id AND i.image_type = 'B' 
WHERE a.post_type = 'B' AND a.category_id = 14   
-- GROUP BY b.blog_id 
*/