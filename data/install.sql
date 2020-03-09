--
-- Add new tab
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('user-finger', 'user-single', 'Finger', 'your fingers', 'fas fa-barcode', '', '0', '', '');

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
  `finger_ref` int(11) NOT NULL,
  `label` TEXT NOT NULL DEFAULT '',
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
('finger-base', 'userfinger-single', 'Finger', 'add new', 'fas fa-barcode', '', '1', '', '');

--
-- add address fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Name', 'label', 'finger-base', 'userfinger-single', 'col-md-4', '', '', '0', '1', '0', '', '', ''),
(NULL, 'number', 'Finger Ref', 'finger_ref', 'finger-base', 'userfinger-single', 'col-md-4', '', '', '0', '1', '0', '', '', ''),
(NULL, 'hidden', 'User', 'user_idfs', 'finger-base', 'userfinger-single', 'col-md-3', '', '/', '0', '1', '0', '', '', '');



--
-- add button
--
INSERT INTO `core_form_button` (`Button_ID`, `label`, `icon`, `title`, `href`, `class`, `append`, `form`, `mode`, `filter_check`, `filter_value`) VALUES
(NULL, 'Add Finger', 'fas fa-plus', 'Add Finger', '/user/finger/add/##ID##', 'primary', '', 'user-view', 'link', '', ''),
(NULL, 'Save Finger', 'fas fa-save', 'Save Finger', '#', 'primary saveForm', '', 'userfinger-single', 'link', '', '');

--
-- Permissions
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`, `needs_globaladmin`) VALUES
('add', 'JBinggi\\User\\Finger\\Controller\\FingerController', 'Add Finger', '', '', 1, 0);
