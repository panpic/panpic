CREATE VIEW view_pages AS
SELECT a.page_cat, a.DATE_ADD, b.*
FROM pp_pages AS a
JOIN pp_pages_desc AS b
ON a.page_id = b.page_id AND a.avail = 1