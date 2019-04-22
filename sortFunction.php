<?php
if (@$_GET['sort'] === "date" && @$_GET['type'] === "desc") {
    SortingDate($files);
}
elseif (@$_GET['sort'] == "date" && @$_GET['type' ]== "asc") {
    SortingDateAsc($files);
}
elseif (@$_GET['sort'] == "name" && @$_GET['type'] == "desc") {
    SortingNameDsc($files);
}
elseif (@$_GET['sort'] == "name" && @$_GET['type'] == "asc") {
    SortingNameAsc($files);
}
elseif (@$_GET['sort'] == "size" && @$_GET['type'] == "desc") {
   SortingSizeDsc($files);
}
elseif (@$_GET['sort'] == "size" && @$_GET['type'] == "asc") {
    SortingSizeAsc($files);
}
elseif (@$_GET['sort' ]== "type" && @$_GET['type'] == "asc") {
   SortingTypeAsc($files);
}
elseif  (@$_GET['sort'] == "type" && @$_GET['type'] == "desc") {
    SortingTypeDsc($files);
}


function  SortingDate(&$files) {
    usort($files, function($a, $b) {
        return $a['3'] <=> $b['3'];
    });
}
function SortingDateAsc(&$files) {
    usort($files, function($a, $b) {
        return $a['3'] <= $b['3'];
    });
}
function SortingNameDsc(&$files) {
    usort($files, function($a, $b) {
        return $a['0'] <= $b['0'];
    });
}
function SortingNameAsc(&$files) {
    usort($files, function($a, $b) {
        return $a['0'] <=> $b['0'];
    });
}
function SortingSizeDsc(&$files) {
    usort($files, function($a, $b) {
        return $a['2'] <= $b['2'];
    });
}
function SortingSizeAsc(&$files) {
    usort($files, function($a, $b) {
        return $a['2'] <=> $b['2'];
    });
}
function SortingTypeAsc(&$files) {
    usort($files, function($a, $b) {
        return $a['3'] <= $b['3'];
    });
}
function SortingTypeDsc(&$files) {
    usort($files, function($a, $b) {
        return $a['3'] <=> $b['3'];
    });
}