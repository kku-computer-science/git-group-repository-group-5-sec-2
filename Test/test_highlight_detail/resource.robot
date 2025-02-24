*** Settings ***
Documentation    A resource file for testing highlight banner in home page.
Library           SeleniumLibrary

*** Variables ***
# ${SERVER}            http://127.0.0.1:8000/
${SERVER}            http://cs05sec267.cpkkuhost.com
${BROWSER}           Chrome
${DELAY}             0.1s

*** Keywords ***
Open Web Page
    Open Browser    ${SERVER}    Chrome
    Maximize Browser Window
    Sleep    2s
    Wait Until Page Contains Element    id=carouselExampleIndicators    timeout=5s