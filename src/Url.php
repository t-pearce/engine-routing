<?php

namespace Engine\Routing;

class Url
{
	private string $scheme;
	private string $domain;
	private ?string $path;
	private array $query = [];
	private ?string $fragment;

	public static function currentPage()
	{
		$self = new static();

		$self->scheme = $_SERVER['REQUEST_SCHEME'];
		$self->domain = $_SERVER['SERVER_NAME'];

		$req_uri = $_SERVER['REQUEST_URI'];

		$req_uri = preg_split("/[?#]/", $req_uri);

		$self->path     = $req_uri[0] ?? null;
		$query          = $req_uri[1] ?? null;
		$self->fragment = $req_uri[2] ?? null;

		if($query !== null)
		{
			$query_pairs = explode("&", $query);

			foreach($query_pairs as $pair)
			{
				[$key, $val] = explode("=", $pair);

				$self->query[$key] = $val;
			}
		}

		return $self;
	}

	public function toString()
	{
		$url = implode("", [$this->scheme, "://", $this->domain, $this->path ?? ""]);

		$query_parts = [];

		foreach($this->query as $key => $value)
		{
			$query_parts[] = implode("=", [$key, $value]);
		}

		$url .= (count($this->query) !== 0 ? "?" . implode("&", $query_parts) : "");
		$url .= (null !== $this->fragment ? "#{$this->fragment}" : "");

		return $url;
	}

	public function setQueryValue(string $key, string $value)
	{
		$this->query[$key] = $value;

		return $this;
	}

	public function getQueryValue(string $key)
	{
		return $this->query[$key] ?? null;
	}
	
	public function setFragment(string $fragment) : self
	{
		$this->fragment = $fragment;
	
		return $this;
	}
	public function setQuery(string $query) : self
	{
		$this->query = $query;
	
		return $this;
	}
	public function setPath(string $path) : self
	{
		$this->path = $path;
	
		return $this;
	}
	public function setDomain(string $domain) : self
	{
		$this->domain = $domain;
	
		return $this;
	}
	public function setScheme(string $scheme) : self
	{
		$this->scheme = $scheme;
	
		return $this;
	}
}