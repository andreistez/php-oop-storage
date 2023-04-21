<?php

class Article
{
	protected int $id;
	public string $title = '';
	public string $content = '';
	protected IStorage $storage;

	public function __construct( IStorage $storage )
	{
		$this->storage = $storage;
	}

	/**
	 * @throws Exception
	 */
	public function create( array $fields ): void
	{
		$this->fieldsValidation( $fields );
		$this->id = $this->storage->create( $fields );
	}

	/**
	 * @param int $id
	 * @return void
	 * @throws Exception	If article was not found by ID.
	 */
	public function load( int $id ): void
	{
		$data = $this->storage->get( $id );

		if( ! $data ) throw new Exception( "Error: article with ID $id not found." );

		$this->fieldsValidation( $data );
		$this->id = $id;
	}

	public function save(): bool
	{
		return $this->storage->update( $this->id, [
			'title'		=> $this->title,
			'content'	=> $this->content
		] );
	}

	/**
	 * @throws Exception
	 */
	protected function fieldsValidation( array $fields ): void
	{
		$title		= $fields['title'] ?? null;
		$content	= $fields['content'] ?? null;

		if( ! $title || ! $content ) throw new Exception( "Error: 'title' and 'content' fields are required." );

		$this->title	= $title;
		$this->content	= $content;
	}
}

