--
-- Add new tab
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('user-finger', 'user-single', 'Finger', 'Recent Finger', 'fas fa-finger', '', '1', '', '');

--
-- Add new partial
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'partial', 'Finger', 'user_finger', 'user-finger', 'user-single', 'col-md-12', '', '', '0', '1', '0', '', '', '');

--
-- create finger table
--
CREATE TABLE `user_finger` (
  `Finger_ID` int(11) NOT NULL,
  `user_idfs` int(11) NOT NULL,
  `comment` TEXT NOT NULL DEFAULT '',
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `user_finger`
  ADD PRIMARY KEY (`Finger_ID`);

ALTER TABLE `user_finger`
  MODIFY `Finger_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- add finger form
--
INSERT INTO `core_form` (`form_key`, `label`, `entity_class`, `entity_tbl_class`) VALUES
('userfinger-single', 'User Finger', 'JBinggi\\User\\Finger\\Model\\Finger', 'JBinggi\\User\\Finger\\Model\\FingerTable');

--
-- add form tab
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('finger-base', 'userfinger-single', 'Finger', 'Recent Finger', 'fas fa-finger', '', '1', '', '');

--
-- add address fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Comment', 'comment', 'finger-base', 'userfinger-single', 'col-md-6', '', '', '0', '1', '0', '', '', ''),
(NULL, 'hidden', 'Finger', 'user_idfs', 'finger-base', 'userfinger-single', 'col-md-3', '', '/', '0', '1', '0', '', '', '');
