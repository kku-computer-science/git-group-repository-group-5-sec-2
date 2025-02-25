*** Settings ***
Documentation    A resource file for testing highlight banner in home page.
Library           SeleniumLibrary

*** Variables ***
# ${SERVER}            http://127.0.0.1:8000
${SERVER}            http://cs05sec267.cpkkuhost.com
${BROWSER}           Chrome
${HIGHLIGHT_DETAIL_URL}        ${SERVER}/highlightdetail/1
${TAG_LINK}                    xpath=(//a[starts-with(@id, 'tagLink-')])[1]

*** Keywords ***
Open Web Page
    Open Browser    ${SERVER}    ${BROWSER}
    Maximize Browser Window
    Sleep    2s
    