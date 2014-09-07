<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
	private $version = [
		'major' => '2',
		'minor' => '0',
		'patch' => '0'
	];
	
	private $branch = [
		'current'   => null,
		'dist'      => 'dist',
		'docs'      => 'gh-pages',
		'downloads' => 'downloads'
	];
	
	public function __construct () {}
	
	/**
	 * Helper do get current branch
	 */
	private function currentBranch () {
		
		if (is_null($this->branch['current'])) {
			
			$res = $this->taskExec('git branch | grep \*')->run();
			$this->branch['current'] = str_replace(['*',' '], '', $res->getMessage());
			
		}
		
		return $this->branch['current'];
	}
	
	/**
	 * Run PHPUnit
	 */
	public function tests ()
	{
		$phpunit_bin = "vendor/phpunit/phpunit/phpunit";
		$phpunit_args = ['--colors', '--verbose', 'tests'];
		
		$res = $this->taskExec($phpunit_bin)->args($phpunit_args)->run();
		
		return $res();
		
	}
	
	/**
	 * Create API documentation
	 */
	 
	public function docApi ()
	{
		if(!$this->tests()) {
			return;
		};
		
		$destdir = "docs/api/v{$this->version['major']}";
		$template = 'clean';

		$this->taskFileSystemStack()->mkdir($destdir)->run();
		$this->taskCleanDir($destdir)->run();
		
		$phpdocumentor_bin = "vendor/phpdocumentor/phpdocumentor/bin/phpdoc";
		$phpdocumentor_args = ["--target='{$destdir}'", "--template='{$template}'", "--filename='./src/Espalda/*.php'"];
		
		$res = $this->taskExec($phpdocumentor_bin)->args($phpdocumentor_args)->run();
		
		return $res();
	
	}
	
	public function publishDoc () {
		
		
	}

}

