:menu
@echo off &COLOR 0A &cls
mode con: cols=48 lines=15
echo.     #####################################
echo.     #       MENU DE OPCOES ARTISAN      #&TITLE MENU DE OPCOES
echo.     #####################################
echo.
echo.           1 - Monitorar Logs
echo.           2 - Limpar Logs
echo.           3 - Rodar server externo
echo.           4 - Rodar server interno
echo.           5 - Restore/Seeder BKP
echo.           9 - Sair
echo. 
echo.     #####################################
echo. 
set /p opcao=#          Escolha uma opcao:

if %opcao% equ 1 (
    call :monitorarLog
) else if %opcao% equ 2 (
    call :limparLog
) else if %opcao% equ 3 (
    call :runar_server_acessoexterno
) else if %opcao% equ 4 (
    call :runar_server_acessointerno
) else if %opcao% equ 5 (
    call :run_bkp
) else if %opcao% equ 9 (
    exit
) else (
    cls &echo.  Opcao invalida. &echo.  Pressione qualquer tecla para voltar ao menu.
    pause >nul
)

goto menu

:monitorarLog
start "" "%~dpnx0"
:repeat
cls &mode con: cols=200 lines=60
echo.  Monitorando Logs...   &TITLE MONITORANDO LOGs
type storage\logs\laravel.log 
timeout /nobreak /t 5 >nul 
goto repeat

:limparLog
cls
echo.   Limpando o arquivo de log... &TITLE LIMPANDO LOG
echo. > storage\logs\laravel.log
timeout /nobreak /t 2 >nul
echo.   Arquivo de log limpo com sucesso.
timeout /nobreak /t 5 >nul
goto menu

:runar_server_acessoexterno
start "" "%~dpnx0"
echo. Levantando server para acesso externo...
@ECHO OFF &TITLE Server is running &mode con: cols=100 lines=5 &php artisan serve --host=0.0.0.0 --port=8000 &exit


:runar_server_acessointerno
start "" "%~dpnx0"
echo. Levantando server padrao...
@ECHO OFF &TITLE Server is running &mode con: cols=100 lines=5 &php artisan serve &exit

:run_bkp
cls &mode con: cols=150 lines=35
echo.   Restaurando e semeando dados de back-up para teste...&echo. &TITLE RESTEURANDO DADOS DE BACK-UP
@ECHO OFF&TITLE RESETA E RESTAURA BKP&php artisan migrate:fresh &php artisan db:seed --class=BKP_Teste_Seeder
timeout /nobreak /t 15 > nul &goto menu
