confirmar = (e) => {
  if (confirm("Seguro que deseas eliminar este registro?")){
    return true
  }else {
    e.preventDefault()
  }
}

let link = document.querySelectorAll(".delete")

for(let i=0; i < link.length; i++){
  link[i].addEventListener('click', confirmar)
}