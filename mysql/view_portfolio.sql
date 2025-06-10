CREATE 
-- ALTER
VIEW view_portfolio AS
SELECT a.blog_id, a.category_id, a.date_add, a.portfolio_year,
	b.slug, b.title, b.title_2, b.short, b.content, b.home_status, b.portfolio_utility, b.portfolio_clients, b.portfolio_skills, b.seo_title, b.seo_description,
	i.path_image, i.path_image_thumb, c.cat_name, c.cat_slug
FROM pp_blog AS a
JOIN pp_blog_translate AS b
ON a.blog_id = b.blog_id 
	AND a.post_type = 'P' 
	AND a.avail = 1
JOIN view_category AS c ON a.category_id = c.post_cat_id		
LEFT JOIN pp_images AS i ON a.blog_id = i.object_id 
	AND i.image_type = 'P'