SET NAMES 'utf8';

SET @category_lft = 0;

SET @category_rgt = 0;

SET @category_parent_id = 0;

SET @root_category_id = 0;

SELECT @root_category_id := `id`, @category_parent_id := `id`, @category_lft := `rgt` FROM `<?php echo $table_prefix ?>categories`
  WHERE `parent_id` = 0 AND `asset_id` = 0 AND `alias` = 'root'
;

SET @category_rgt = @category_lft + 1;

SET @category_asset_id = 0;

SET @category_title = '<?php echo $category_title ?>';

SET @category_alias = '<?php echo $category_alias ?>';

SET @category_path = @category_alias;

SET @category_description = '<?php echo $category_description ?>';

INSERT `<?php echo $table_prefix ?>categories` SET
  `asset_id` = @category_asset_id,
  `parent_id` = @category_parent_id,
  `lft` = @category_lft,
  `rgt` = @category_rgt,
  `level` = 1,
  `path` = @category_path,
  `extension` = 'com_content',
  `title` = @category_title,
  `alias` = @category_alias,
  `description` = @category_description,
  `published` = 1,
  `access` = 1,
  `params` = '{"category_layout":"","image":""}',
  `metadesc` = '',
  `metakey` = '',
  `metadata` = '{"author":"","robots":""}',
  `created_time` = NOW(),
  `modified_time` = NOW(),
  `language` = '*'
;

SET @category_id = LAST_INSERT_ID();

UPDATE `<?php echo $table_prefix ?>categories` SET
  `rgt` = @category_rgt + 1
  WHERE `id` = @root_category_id
;

SET @content_asset_id = 0;

SET @content_asset_level = 0;

SET @content_asset_rgt = 0;

SELECT @content_asset_id := `id`, @content_asset_level := `level`, @content_asset_rgt := `rgt`
  FROM `<?php echo $table_prefix ?>assets` WHERE `name` = 'com_content'
;

SET @category_asset_lft = @content_asset_rgt;

SET @category_asset_rgt = @category_asset_lft + 1;

SET @category_asset_level = @content_asset_level + 1;

SET @category_asset_name = CONCAT('com_content.category.', @category_id);

INSERT `<?php echo $table_prefix ?>assets` SET
  `parent_id` = @content_asset_id,
  `lft` = @category_asset_lft,
  `rgt` = @category_asset_rgt,
  `level` = @category_asset_level,
  `name` = @category_asset_name,
  `title` = @category_title,
  `rules` = '{"core.create":{"6":1,"3":1},"core.delete":{"6":1},"core.edit":{"6":1,"4":1},"core.edit.state":{"6":1,"5":1},"core.edit.own":{"6":1,"3":1}}'
;

SET @category_asset_id = LAST_INSERT_ID();

SET @content_asset_rgt = @category_asset_rgt + 1;

UPDATE `<?php echo $table_prefix ?>assets` SET `rgt` = @content_asset_rgt
  WHERE `id` = @content_asset_id
;

UPDATE `<?php echo $table_prefix ?>categories` SET `asset_id` = @category_asset_id
  WHERE `id` = @category_id
;

<?php foreach($articles as $article): ?>

SET @article_asset_id = 0;

SET @article_title = '<?php echo $article->title ?>';

SET @article_alias = '<?php echo $article->alias ?>';

SET @article_content = '<?php echo addcslashes($article->content, "'") ?>';

INSERT `<?php echo $table_prefix ?>content` SET
  `asset_id` = @article_asset_id,
  `title` = @article_title,
  `alias` = @article_alias,
  `introtext` = @article_content,
  `fulltext` = '',
  `state` = 1,
  `catid` = @category_id,
  `created` = NOW(),
  `modified` = NOW(),
  `images` = '{"image_intro":"","float_intro":"","image_intro_alt":"","image_intro_caption":"","image_fulltext":"","float_fulltext":"","image_fulltext_alt":"","image_fulltext_caption":""}',
  `urls` = '{"urla":false,"urlatext":"","targeta":"","urlb":false,"urlbtext":"","targetb":"","urlc":false,"urlctext":"","targetc":""}',
  `attribs` = '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}',
  `metakey` = '',
  `metadesc`  = '',
  `access` = 1,
  `metadata` = '{"robots":"","author":"","rights":"","xreference":""}',
  `language` = '*',
  `xreference` = ''
;

SET @article_id = LAST_INSERT_ID();

SET @article_asset_lft = @category_asset_rgt;

SET @article_asset_rgt = @article_asset_lft + 1;

SET @category_asset_rgt = @article_asset_rgt + 1;

SET @content_asset_rgt = @category_asset_rgt + 1;

SET @article_asset_level = @category_asset_level + 1;

SET @article_asset_name = CONCAT('com_content.article.', @article_id);

INSERT `<?php echo $table_prefix ?>assets` SET
  `parent_id` = @category_asset_id,
  `lft` = @article_asset_lft,
  `rgt` = @article_asset_rgt,
  `level` = @article_asset_level,
  `name` = @article_asset_name,
  `title` = @article_title,
  `rules` = '{"core.create":{"6":1,"3":1},"core.delete":{"6":1},"core.edit":{"6":1,"4":1},"core.edit.state":{"6":1,"5":1},"core.edit.own":{"6":1,"3":1}}'
;

SET @article_asset_id = LAST_INSERT_ID();

UPDATE `<?php echo $table_prefix ?>assets` SET `rgt` = @category_asset_rgt WHERE `id` = @category_asset_id;

UPDATE `<?php echo $table_prefix ?>assets` SET `rgt` = @content_asset_rgt WHERE `id` = @content_asset_id;

UPDATE `<?php echo $table_prefix ?>content` SET `asset_id` = @article_asset_id WHERE `id` = @article_id;

<?php endforeach ?>
