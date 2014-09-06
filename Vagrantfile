Vagrant::Config.run do |config|
  config.vm.box = "Ubuntu_Trusty_Tahr:i386"
  #config.vm.box = "precise32"
  config.vm.box_url = "https://cloud-images.ubuntu.com/vagrant/trusty/current/trusty-server-cloudimg-i386-vagrant-disk1.box"
  
  config.vm.provision :shell, path: "vagrant.sh", keep_color: false
  config.vm.provision :file, source: "~/.ssh/id_rsa", destination: "~/.ssh/id_rsa"

  config.vm.forward_port 80, 1780
end