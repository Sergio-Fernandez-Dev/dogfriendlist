INSERT INTO `Users` (
    username,
    email, 
    visibility, 
    city, 
    country, 
    name, 
    surname, 
    img, 
    about_me, 
    password, 
    role
)
VALUES (
    'Zegius', 
    'zegius@hotmail.com', 
    0, 
    'Oviedo', 
    'Spain', 
    'Sergio',
    'Fernández Fernández', 
    'users/common/default-profile-picture.jpg', 
    'Me encantan los perros', 
    '4991d8ea19230ad9ccf4c9986c2a3b31', 
    1
);

INSERT INTO `Users` (
    username,
    email, 
    visibility, 
    city, 
    country, 
    about_me, 
    password
)
VALUES (
    'FakeUser', 
    'fake@email.com', 
    1, 
    'Tordesillas', 
    'Spain',  
    'Soy un usuario falso', 
    'e6d20eb05401787478fa47b85944e7a6'
);