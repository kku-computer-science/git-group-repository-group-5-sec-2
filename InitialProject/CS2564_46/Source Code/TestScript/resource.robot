*** Settings ***
Documentation    A resource file for testing "Setting Highlight" page.
Library           SeleniumLibrary

*** Variables ***
${SERVER}            127.0.0.1:8000
# ${SERVER}            cs05sec267.cpkkuhost.com
${BROWSER}           Chrome
${LOGIN URL}         http://${SERVER}/login
${USERNAME}          admin@gmail
${PASSWORD}          12345678
${DELAY}             0.1s

*** Keywords ***
Open Browser To Login Page
    Open Browser    ${LOGIN URL}    ${BROWSER}
    Maximize Browser Window            
    Set Selenium Speed    ${DELAY}
    Title Should Be       Login

Input Username
    [Arguments]    ${username}
    Input Text    id:username    ${username}

Input Password
    [Arguments]    ${password}
    Input Text    id:password    ${password}

Submit Credentials
    Click Button    id:login-button

Go To Highlight Setting Page
    Scroll Element Into View         xpath=//span[text()='Highlight Setting']
    Click Element                    xpath=//span[text()='Highlight Setting']