*** Settings ***
Documentation    A resource file for testing "Setting Highlight" page.
Library           SeleniumLibrary

*** Variables ***
${SERVER}            127.0.0.1:8000
# ${SERVER}            cs05sec267.cpkkuhost.com
${BROWSER}           Chrome
${LOGIN URL}         http://${SERVER}/login
${DELAY}             0.1s
${USERNAME}          staff@gmail.com
${PASSWORD}          123456789

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
    Click Button    xpath=//button[@type='submit']    # click the login button
    Title Should Be    Dashboard

Go To Highlight Setting Page
    Scroll Element Into View         xpath=//span[text()='Highlight Setting']
    Click Element                    xpath=//span[text()='Highlight Setting']
    Title Should Be                  Highlight Papers