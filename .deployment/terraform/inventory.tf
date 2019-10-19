data "template_file" "inventory" {
  template = file("templates/inventory.tpl")

  depends_on = [
    "digitalocean_droplet.managers",
    "digitalocean_droplet.workers"
  ]

  vars {
    managers = ""
    workers = ""
  }
}

resource "null_resource" "cmd" {
  triggers {
    template_rendered = data.template_file.inventory.rendered
  }

  provisioner "local-exec" {
    command = "echo '${data.template_file.inventory.rendered}' > ../ansible/inventory"
  }
}
