CREATE DATABASE  IF NOT EXISTS `songs` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `songs`;
--

-- --------------------------------------------------------

--
-- Struktur för tabell 'Album'
--

CREATE TABLE Album (
  AlbumId int(11) NOT NULL auto_increment,
  AlbumName varchar(45) NOT NULL,
  PRIMARY KEY  (AlbumId)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Data i tabell 'Album'
--

INSERT INTO Album (AlbumId, AlbumName) VALUES
(1, 'Security');

-- --------------------------------------------------------

--
-- Struktur för tabell 'Songs'
--

CREATE TABLE Songs (
  SongId int(11) NOT NULL auto_increment,
  SongTrackNr int(11) NOT NULL,
  SongName varchar(45) NOT NULL,
  SongDuration int(11) NOT NULL,
  AlbumId int(11) NOT NULL,
  PRIMARY KEY  (SongId),
  KEY fk_AlbumSong (AlbumId)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Data i tabell 'Songs'
--

INSERT INTO Songs (SongId, SongTrackNr, SongName, SongDuration, AlbumId) VALUES
(1, 1, 'The Rhythm of the Heat', 5, 1),
(2, 2, 'San Jacinto', 6, 1),
(3, 3, 'I Have the Touch', 4, 1),
(4, 4, 'The Family and the Fishing Net', 7, 1),
(5, 5, 'Shock the Monkey', 5, 1),
(6, 6, 'Lay Your Hands on Me', 6, 1),
(7, 7, 'Wallflower', 6, 1),
(8, 8, 'Kiss of Life', 4, 1);

-- --------------------------------------------------------

--
-- Struktur för tabell 'users'
--

CREATE TABLE users (
  id int(5) NOT NULL auto_increment,
  `name` varchar(25) NOT NULL,
  email varchar(25) NOT NULL,
  pass varchar(40) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Data i tabell 'users'
--

INSERT INTO users (id, name, email, pass) VALUES
(1, 'ja37', 'ja37@flygvapnet.se', '1234'),
(2, 'ja35', 'ja35@flygvapnet.se', '1234'),
(3, 'jas39', 'jas39@flygvapnet.se', '1234'),
(4, 'ja37', 'ja37viggen@flygvapnet.se', '1234'),
(8, 'test', 'test@test.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(9, 'jas39', 'jas39@jas.com', '81dc9bdb52d04dc20036dbd8313ed055');

--
-- create store procedure sp_songs'
--

CREATE 'sp_songs'()
BEGIN
SELECT Songs.SongId,
Album.AlbumName, 
Songs.SongTrackNr,
Songs.SongName, 
Songs.SongDuration 

FROM
(Album
JOIN Songs ON ((Album.AlbumId = Songs.AlbumId)));
END
