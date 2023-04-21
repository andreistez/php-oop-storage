<?php

include_once 'IStorage.php';
include_once 'MemoryStorage.php';
include_once 'FileStorage.php';
include_once 'Article.php';

//$ms		= new MemoryStorage();
$ms		= FileStorage::getInstance( 'articles.txt' );
$art1	= new Article( $ms );
try {
	$art1->create( [
		'title' => 'Title 1',
		'content' => 'Content 1'
	] );
} catch( Exception $e ){
	echo $e->getMessage();
	exit;
}
echo '<pre>' . print_r( $ms, 1 ) . '</pre>';
echo '<hr />';

$ms2	= FileStorage::getInstance( 'articles-alt.txt' );
$art1	= new Article( $ms2 );
try {
	$art1->create( [
		'title' => 'Title 2',
		'content' => 'Content 2'
	] );
} catch( Exception $e ){
	echo $e->getMessage();
	exit;
}
echo '<pre>' . print_r( $ms2, 1 ) . '</pre>';
echo '<hr />';
echo '<pre>' . print_r( $ms, 1 ) . '</pre>';
echo '<hr />';

