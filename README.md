# local_floatingnews — Notícias rápidas Moodle

Plugin local para Moodle 5.0+ que exibe um painel lateral flutuante com notícias rotativas.

## Recursos do MVP

- Painel lateral fixo, independente das regiões de blocos do tema.
- Notícias com título, texto curto, imagem e link.
- Rotação automática com intervalo configurável.
- Controle de ativo/inativo, data inicial, data final e ordem.
- Página administrativa para cadastrar, editar e excluir notícias.
- Permissão `local/floatingnews:manage` para gerenciar notícias.

## Instalação

1. Copie a pasta `floatingnews` para `moodle/local/floatingnews`.
2. Acesse **Administração do site > Notificações** ou rode `php admin/cli/upgrade.php`.
3. Limpe os caches do Moodle.
4. Acesse `/local/floatingnews/manage.php` para cadastrar notícias.
5. Ajuste as configurações em **Administração do site > Plugins > Plugins locais > Notícias rápidas Moodle**.

## Observação

Este é um MVP para homologação. Teste primeiro fora da produção.


## 0.1.1-alpha

- Adicionado fallback usando `before_footer_html_generation` para temas que não renderizam corretamente o hook do topo do body.
- Evita duplicação caso os dois hooks sejam executados na mesma página.
