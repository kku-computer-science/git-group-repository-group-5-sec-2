*** Settings ***
Documentation    A resource file for testing highlight banner in home page.
Library           SeleniumLibrary

*** Variables ***
# ${SERVER}            http://127.0.0.1:8000/
${SERVER}            http://cs05sec267.cpkkuhost.com
${BROWSER}           Chrome
${DELAY}             0.1s
${NAVBAR_HIGHLIGHT}         xpath=//nav//a[@href='/allhighlights']
${ALLHIGHLIGHTS_HEADER}     xpath=//h1[contains(text(),'Highlights')]


*** Keywords ***
Open Web Page
    Open Browser    ${SERVER}    Chrome
    Maximize Browser Window
    Sleep    2s
    Wait Until Page Contains Element    ${NAVBAR_HIGHLIGHT}    timeout=5s

Click Navbar Highlights
    [Documentation]    Click "Highlights" in the navbar
    Click Element    ${NAVBAR_HIGHLIGHT}
    Sleep    3s

Verify All Highlights Page
    [Documentation]    ตรวจสอบว่าหน้า All Highlights ถูกโหลดแล้วด้วยการเช็ค header ที่มีคำว่า "Highlights"
    Wait Until Element Is Visible    ${ALLHIGHLIGHTS_HEADER}    timeout=5s
    Element Should Be Visible    ${ALLHIGHLIGHTS_HEADER}

Click Invalid Navbar Link
    [Documentation]    ลองคลิกที่ลิงก์ที่ไม่ถูกต้องแล้วตรวจสอบว่าเกิด error
    Run Keyword And Expect Error    *    Click Element    ${INVALID_NAVBAR_LINK}