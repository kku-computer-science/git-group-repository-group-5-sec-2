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
${ALLHIGHLIGHTS_URL}        ${SERVER}/allhighlights
${HIGHLIGHT_ITEM}            xpath=//div[contains(@class,'highlight-item')]
${FIRST_HIGHLIGHT_LINK}      xpath=(//div[contains(@class,'col-lg-4 col-md-6 col-12')])//a

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

Open All Highlights Page
    [Documentation]    Open the All Highlights page
    Open Browser    ${ALLHIGHLIGHTS_URL}    ${BROWSER}
    Maximize Browser Window
    Sleep    2s
    Wait Until Page Contains Element    ${ALLHIGHLIGHTS_HEADER}    timeout=5s

Verify All Highlights Page Loaded
    [Documentation]    Verify that the All Highlights page is loaded by checking the header
    Wait Until Element Is Visible    ${ALLHIGHLIGHTS_HEADER}    timeout=5s
    Element Should Be Visible    ${ALLHIGHLIGHTS_HEADER}
    Wait Until Page Contains Element    ${HIGHLIGHT_ITEM}    timeout=5s

Click First Highlight Item
    [Documentation]    Click first highlight item
    Click Element    ${FIRST_HIGHLIGHT_LINK}
    Sleep    5s

Verify Highlight Detail Page Loaded
    [Documentation]    Verify that the highlight detail page is loaded by checking the URL
    ${current_url}=    Get Location
    Should Contain    ${current_url}    highlightdetail    msg=Expected URL to contain "highlightdetail"

Close Browser Session
    Close Browser
