<?php

include('storage.php');



class TeamStorage extends Storage {
    public function __construct()
    {
        parent::__construct(new JsonIO('storage/teams.json'));
    }
}

class MatchesStorage extends Storage {
    public function __construct()
    {
        parent::__construct(new JsonIO('storage/matches.json'));
    }
}

class UsersStorage extends Storage {
    public function __construct()
    {
        parent::__construct(new JsonIO('storage/users.json'));
    }
}

class CommentsStorage extends Storage {
    public function __construct()
    {
        parent::__construct(new JsonIO('storage/comments.json'));
    }
}


?>