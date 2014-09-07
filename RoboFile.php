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
		'downloads' => 'master'
	];
	
	private $remote = 'origin';
	
	private $path = null;
	
	public function __construct ()
	{
		$this->branch['current'] = $this->currentGitBranch();
		$this->path = getcwd();
	}
	
	/******************************************************************
	 * Helpers
	 */
	
	/**
	 * Return the formated version
	 * @param string $format
	 * @return string
	 */
	private function getVersion($format='complete')
	{
		switch ($format) {
		case 'nominal' :
			return 'v'.$this->version['major'];
		case 'nominal-complete':
			return "v{$this->version['major']}.{$this->version['minor']}.{$this->version['patch']}";
		case 'complete':
		default :
			return $this->version['major'].".".$this->version['minor'].".". $this->version['patch'];
		}
	}
	
	/**
	 * Print a message in the console
	 * @param string $message
	 */
	private function printInfo ($message)
	{
		$this->printTaskInfo('###');
		$this->printTaskInfo('### ' . $message);
		$this->printTaskInfo('###');
	}
	
	/**
	 * Return the current branch
	 * @return string
	 */
	private function currentGitBranch () {
			
		$res = $this->taskExec('git branch | grep \*')->run();
		return  str_replace(['*',' '], '', $res->getMessage());
	}
	
	private function commited () {

		$res  = $this->taskExec('git status')->run();
		return strpos($res->getMessage(), 'nothing to commit') !== FALSE ? true : false;
		
	}
	
	/******************************************************************
	 * Tasks
	*/
	
	/**
	 * Clear the temporary folders
	 */
	public function clear ()
	{
		$this->taskDeleteDir(["{$this->path}/.for_publish"])->run();
	}
	
	/**
	 * Run PHPUnit
	 */
	public function tests ()
	{
		$this->printInfo('Doing tests ...');
		
		$phpunit_bin = "vendor/phpunit/phpunit/phpunit";
		$phpunit_args = ['--colors', '--verbose', 'tests'];
		
		$res = $this->taskExec($phpunit_bin)->args($phpunit_args)->run();
		
		return $res();
		
	}
	
	/**
	 * Create API documentation
	 * @param string $destination
	 */
	 
	public function docApi ($destination = 'local')
	{
		if(!$this->tests()) {
			return;
		};
		
		$this->printInfo('Generating API documentation ...');
		
		switch ($destination) {
		case 'publish' :
			$destdir = "{$this->path}/.for_publish/docs/api/{$this->getVersion('nominal')}";
			break;
		case 'local':
		default :
			$destdir = "{$this->path}/docs/api/{$this->getVersion('nominal')}";
		}
		
		$template = 'clean';

		$this->taskFileSystemStack()->mkdir($destdir)->run();
		$this->taskCleanDir($destdir)->run();
		
		$phpdocumentor_bin = "vendor/phpdocumentor/phpdocumentor/bin/phpdoc";
		$phpdocumentor_args = ["--target='{$destdir}'", "--template='{$template}'", "--filename='./src/Espalda/*.php'"];
		
		$res = $this->taskExec($phpdocumentor_bin)->args($phpdocumentor_args)->run();
		
		return $res();
	
	}
	
	/**
	 * Create compressed files for publish
	 */
	public function compress ()
	{
		$this->printInfo('Generating compresseds ...');
		
		chdir('src');
		
		$destdir = "{$this->path}/.for_publish/compresseds/{$this->getVersion('nominal')}/";
		
		$this->taskFileSystemStack()->mkdir($destdir)->run();
		
		$zip = "Espalda_PHP-{$this->getVersion()}.zip";
		$targz = "Espalda_PHP-{$this->getVersion()}.tar.gz";
		
		$zip_args = ["-r", "{$destdir}{$zip}", "Espalda"];
		
		$res1 = $this->taskExec('zip')->args($zip_args)->run();
		
		$targz_args = ["-zcvf", "{$destdir}{$targz}", "Espalda"];
		$res2 = $this->taskExec('tar')->args($targz_args)->run();
		
		chdir($this->path);
		
		return $res1() and $res2();
		
	}
	
	public function publishDoc ()
	{
		$this->printInfo('Preparing API Documentation to publish ...');
		
		$this->docApi('publish');
		
		$this->printInfo('Publishing API Documentation ...');
		
		//mudando para o branch de documentação
		$this->taskGitStack()->checkout($this->branch['docs'])->run();
		
		//copiando documentação para o local certo
		$docs_from = "{$this->path}/.for_publish/docs/api/{$this->getVersion('nominal')}/";
		$docs_to = "{$this->path}/docs/api/";
		
		$res1 = $this->taskExec("cp -r {$docs_from} {$docs_to}")->run();
		
		//commiting and push
		$this->taskGitStack()
		->stopOnFail()
		->add('-A')
		->commit('updated API documentation')
		->push($this->remote, $this->branch['docs'])
		->checkout($this->branch['current'])
		->run();
		
	}
	
	public function publishCompress ()
	{
		$this->printInfo('Preparing compressed files to publish ...');
		
		$this->compress();
		
		$this->printInfo('Publishing compressed files ...');
		
		//mudando para o branch de estaticos comprimidos
		$this->taskGitStack()->checkout($this->branch['downloads'])->run();
		
		//copiando arquivos comprimidos para o local certo
		$statics_from = "{$this->path}/.for_publish/compresseds/{$this->getVersion('nominal')}/*";
		$statics_to = "{$this->path}/{$this->getVersion('nominal')}";
		
		$this->taskFileSystemStack()->mkdir($statics_to)->run();
		$res1 = $this->taskExec("cp -r {$statics_from} {$statics_to}")->run();
		
		//commiting and push
		$this->taskGitStack()
		->stopOnFail()
		->add('-A')
		->commit('updated static files for download Espalda-PHP')
		->push($this->remote, $this->branch['downloads'])
		->checkout($this->branch['current'])
		->run();
		
	}
	
	public function publishDist ()
	{
		$this->printInfo('Preparing API files to publish ...');
		
		$apifiles_publish = [
			"{$this->path}/src",
			"{$this->path}/composer.json",
			"{$this->path}/COPYING"
		];
		$apifiles_temp = "{$this->path}/.for_publish/dist";
		
		$this->taskFileSystemStack()->mkdir($apifiles_temp)->run();
		$this->taskCleanDir($apifiles_temp)->run();
		
		$res1 = $this->taskExec("cp -r " . implode(' ', $apifiles_publish) . " {$apifiles_temp}")->run();
		
		$this->printInfo('Publishing API Files ...');
		
		//mudando de branch
		$this->taskGitStack()->checkout($this->branch['dist'])->run();
	
		//copiando arquivos da api para o local certo
		$apifiles_to = "{$this->path}";
		
		$this->taskCleanDir($apifiles_to . '/src')->run();
		$res1 = $this->taskExec("cp -rf {$apifiles_temp} {$apifiles_to}")->run();
	
		//commiting and push
		$this->taskGitStack()
		->stopOnFail()
		->add('-A')
		->commit('updated Espalda-PHP API files for distribution ')
		->push($this->remote, $this->branch['dist'])
		->run();
		/*
		///criando tag
		$this->taskGitStack->exec("tag -a {$this->getVersion('nominal-complete')} -m 'Stable release for {$this->getVersion('nominal')}'");
		$this->taskGitStack->exec("push {$this->remote} --tags");
		*/
		//come back to current branch
		$this->taskGitStack()
		->stopOnFail()
		->checkout($this->branch['current'])
		->run();
	
	}
	
	public function publish ()
	{
		$this->printInfo('Did you do git commit?');
		
		if (!$this->commited()) {
			$this->printInfo('You didn\'t commited your work');
			return;
		}
		
		//$this->publishDoc();
		//$this->publishCompress();
		$this->publishDist();
		
	}

}

