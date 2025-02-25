*** Settings ***
Documentation    A resource file for testing highlight banner in home page.
Library           SeleniumLibrary

*** Variables ***
# ${SERVER}            http://127.0.0.1:8000/
${SERVER}            http://cs05sec267.cpkkuhost.com
${BROWSER}           Chrome

*** Keywords ***
Open Web Page
    Open Browser    ${SERVER}    ${BROWSER}
    Maximize Browser Window
    Sleep    2s