<?php

namespace jesperoestergaardjensen\MyDB;

class DbEntity extends Table
{
    use PaginationTrait;
    use QueryBuilderTrait;
    use PropertiesTrait;
}
