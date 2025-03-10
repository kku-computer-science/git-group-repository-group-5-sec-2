*** Settings ***
Documentation    A resource file for testing highlight tag page.
Library    SeleniumLibrary

*** Variables ***
${BROWSER}          Chrome
# ${SERVER}            http://127.0.0.1:8000
${SERVER}            http://cs05sec267.cpkkuhost.com
${TAG_NAME}         cp
${TAG_PAGE_URL}     ${SERVER}/highlights/tag/${TAG_NAME}
${HEADING}          xpath=//h1[contains(text(),'ผลการค้นหาสำหรับ')]
${COUNT_TEXT}       xpath=//p[contains(text(),'พบทั้งหมด')]
${HIGHLIGHT_ITEM}   xpath=//div[@class = 'col-12']
${FIRST_HIGHLIGHT_LINK}      xpath=(//div[contains(@class,'col-12')])//a

*** Keywords ***
Open Tag Page
    Open Browser    ${TAG_PAGE_URL}    ${BROWSER}
    Maximize Browser Window
    Sleep    2s
    Wait Until Page Contains Element    ${HEADING}    timeout=5s

Verify Tag Page Loaded
    ${heading_text}=    Get Text    ${HEADING}
    Should Contain    ${heading_text}    ${TAG_NAME}    msg=Heading should contain the tag name
    Element Should Be Visible    ${COUNT_TEXT}
    Wait Until Page Contains Element    ${HIGHLIGHT_ITEM}    timeout=5s

Click First Highlight
    Click Element    ${FIRST_HIGHLIGHT_LINK}
    Sleep    3s
    ${current_url}=    Get Location
    Should Contain    ${current_url}    highlightdetail    msg=Expected URL to contain "highlightdetail"
    Go Back
    Sleep    2s

Close Tag Page
    Close Browser
