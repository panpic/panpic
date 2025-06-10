CREATE 
-- ALTER
VIEW view_category AS
SELECT a.posts_no, a.home_status, a.parents, a.level, a.lft, a.rgt, b.* 
FROM pp_post_category AS a
JOIN pp_post_category_desc AS b
ON a.post_cat_id = b.post_cat_id
WHERE a.parents > 0 AND b.lang = 'vi'