Vagrant::Config.run do |config|
  config.vm.box = "precise32"
  config.vm.box_url = "http://files.vagrantup.com/precise32.box"

  config.vm.provision :shell, path: "vagrant.sh", keep_color: false
  config.vm.provision :file, source: "~/.ssh/id_rsa", destination: "~/.ssh/id_rsa"

  config.vm.forward_port 80, 1780
end
