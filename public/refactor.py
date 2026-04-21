import os
import re

directory = r"C:\xampp\htdocs\scambus\app\controladores"

# Regex patterns
class_pattern = re.compile(r'class\s+(Controlador\w+)\s*\{')
view_pattern = re.compile(r'require_once\s+"[^"]*cabecalho\.php";\s*require_once\s+"[^"]*?app/views/([^"]+)\.php";\s*require_once\s+"[^"]*rodape\.php";', re.DOTALL)
header_pattern = re.compile(r'header\s*\(\s*"Location:\s*\?url=([^"]+)"\s*\)\s*;')

for filename in os.listdir(directory):
    if filename.endswith(".php") and filename not in ["ControladorHome.php", "ControladorAutenticacao.php"]:
        filepath = os.path.join(directory, filename)
        
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()

        # Check if already refactored
        if 'extends Controlador' in content:
            continue

        # Modify class definition
        content = class_pattern.sub(r'require_once ROOT . "/nucleo/Controlador.php";\n\nclass \1 extends Controlador {', content, count=1)
        
        # Modify view requires
        content = view_pattern.sub(r"$this->view('\1', get_defined_vars());", content)
        
        # Modify redirects
        content = header_pattern.sub(r"$this->redirect('\1');", content)

        # In ControladorServico, we need to add $this->auth(); to:
        # salvar(), atualizar(), proponhaTroca(), alterarStatus(), excluir()
        # We can just do a very basic string replacement for $this->auth() on missing auth endpoints
        if filename == "ControladorServico.php":
            content = content.replace("public function salvar(){", "public function salvar(){\n        $this->auth();")
            content = content.replace("public function atualizar(){", "public function atualizar(){\n        $this->auth();")
            content = content.replace("public function editar($id){", "public function editar($id){\n        $this->auth();")
            content = content.replace("public function propoeTroca", "public function propoeTroca")
        
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Refactored {filename}")
