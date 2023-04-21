<?php

class FileStorage implements IStorage
{
	protected			array	$records	= [];
	protected			int		$ai			= 0;
	protected	static	string	$dbPath;
	protected	static	array	$instances	= [];

	public static function getInstance( string $path = 'db.txt' ): static
	{
		self::$dbPath = $path;

		if( ! array_key_exists( $path, self::$instances ) ) self::$instances[$path] = new static();

		return self::$instances[$path];
	}

	protected function __construct(){
		if( file_exists( self::$dbPath ) ){
			$data			= json_decode( file_get_contents( self::$dbPath ), true );
			$this->records	= $data['records'];
			$this->ai		= $data['ai'];
		}
	}

	public function create( array $fields ): int
	{
		$id					= ++$this->ai;
		$this->records[$id]	= $fields;
		$this->save();

		return $id;
	}

	public function get( int $id ): ?array
	{
		return $this->records[$id] ?? null;
	}

	public function remove( int $id ): bool
	{
		if( array_key_exists( $id, $this->records ) ){
			unset( $this->records[$id] );
			$this->save();
			return true;
		}

		return false;
	}

	public function update( int $id, array $fields ): bool
	{
		if( array_key_exists( $id, $this->records ) ){
			$this->records[$id] = array_merge( $this->records[$id], $fields );
			$this->save();

			return true;
		}

		return false;
	}

	protected function save(): void
	{
		file_put_contents( self::$dbPath, json_encode( [
			'records'	=> $this->records,
			'ai'		=> $this->ai
		] ) );
	}
}

