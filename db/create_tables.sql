use gitdocs;
CREATE TABLE IF NOT EXISTS Users(u_id VARCHAR(40) primary key, pwd_hash varchar(40) NOT NULL, display_name VARCHAR(40), icon_ptr VARCHAR(40));
CREATE TABLE IF NOT EXISTS Documents(doc_id INTEGER primary key, name VARCHAR(40));
CREATE TABLE IF NOT EXISTS Versions(doc_ID Integer references Documents(doc_id), u_id VARCHAR(40) references Users(u_id), repo_ptr VARCHAR(40));
quit 
