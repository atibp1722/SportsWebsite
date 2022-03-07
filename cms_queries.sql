<!-- CREATING THE DATABASE -->
CREATE TABLE `admin` ( `id` int(10) NOT NULL, `datetime` varchar(50) NOT NULL, `username` varchar(100) NOT NULL, `password` varchar(150) NOT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1
ALTER TABLE `admin` ADD PRIMARY KEY (`id`)


<!-- CREATING THE NEW ADMIN -->
INSERT INTO `admin` (`id`, `datetime`, `username`, `password`) VALUES (5, '26-03-2021 14:17:12', 'ram', 'admin123')

<!-- CREATING NEW CATEGORY -->
CREATE TABLE `category` ( `id` int(10) NOT NULL, `name` varchar(25) NOT NULL, `author` varchar(50) NOT NULL, `datetime` varchar(50) NOT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1
INSERT INTO `category` (`id`, `name`, `author`, `datetime`) VALUES (1, 'Football', 'admin', '16-03-2021 16:02:18'), (2, 'Cricket', 'admin', '20-03-2021 14:39:45'), (3, 'Basketball', 'ram', '26-03-2021 15:33M:57')
ALTER TABLE `category` ADD PRIMARY KEY (`id`)

<!-- CREATING NEW COMMENT -->
CREATE TABLE `comment` ( `id` int(10) NOT NULL, `datetime` varchar(50) NOT NULL, `name` varchar(50) NOT NULL, `email` varchar(50) NOT NULL, `comment` varchar(750) NOT NULL, `postId` int(10) NOT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1
ALTER TABLE `comment` ADD PRIMARY KEY (`id`), ADD KEY `index` (`postId`)

<!-- ADDING postId AS FOREIGN KEY TO COMMENT TABLE -->
ALTER TABLE `comment` ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
INSERT INTO `comment` (`id`, `datetime`, `name`, `email`, `comment`, `postId`) VALUES (4, '25-03-2021 12:37:51', 'nirajan', 'nirajan@yahoo.com', 'this is just a sample dummy comment.', 11), (5, '25-03-2021 12:41:36', 'Sita', 'sita123@gmail.com', 'This is dummy text.', 11), (6, '25-03-2021 12:41:59', 'Reeta', 'reeta321@hotmail.com', 'this is to check if this sections is working properly or not.', 11)

<!-- CREATING NEW POST -->
CREATE TABLE `posts` ( `id` int(10) NOT NULL, `datetime` varchar(15) NOT NULL, `name` varchar(50) NOT NULL, `category` varchar(10) NOT NULL, `author` varchar(20) NOT NULL, `image` varchar(50) NOT NULL, `content` varchar(1200) NOT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1
ALTER TABLE `posts` ADD PRIMARY KEY (`id`)
INSERT INTO `posts` (`id`, `datetime`, `name`, `category`, `author`, `image`, `content`) VALUES (11, '20-03-2021 15:2', 'Edit Content Dummy', 'Football', 'admin', '', 'this is sample text. '), (13, '26-03-2021 15:3', 'Dummy Edited Post to Testing', 'Cricket', 'admin', 'desert.png', 'testing'), (14, '26-03-2021 15:3', 'Cricket News', 'Cricket', 'ram', 'ads.png', 'test')
