*** Settings ***
Documentation    A resource file for testing highlight detail page.
Library           SeleniumLibrary

*** Variables ***
# ${SERVER}            http://127.0.0.1:8000
${SERVER}            http://cs05sec267.cpkkuhost.com
${BROWSER}           Chrome
${HIGHLIGHT_DETAIL_URL}        ${SERVER}/highlightdetail/1
${COVER_IMAGE}                 xpath=//img[contains(@class,'cover-image')]
${TITLE}                       xpath=//h1[contains(@class,'title')]
${CREATION_INFO}               xpath=//p[@id='creationInfo']
${DETAIL_TEXT}                 xpath=//pre[contains(@class,'detail')]
${TAG_LINK}                    xpath=(//a[starts-with(@id, 'tagLink-')])[1]
${GALLERY_IMAGE}               xpath=(//img[@class='image'])[1]
${IMAGE_MODAL}                 xpath=//div[contains(@id, 'imageModal') and contains(@class, 'modal')]
${IMAGE_MODAL_VISIBLE}         xpath=//div[contains(@id, 'imageModal') and contains(@class, 'modal') and contains(@class, 'show')]
${MODAL_CLOSE_BUTTON}          xpath=//button[contains(@class, 'btn-close')]

*** Keywords ***
Open Highlight Detail Page
    Open Browser    ${HIGHLIGHT_DETAIL_URL}    ${BROWSER}
    Maximize Browser Window
    Sleep    2s
    Wait Until Page Contains Element    ${COVER_IMAGE}    timeout=5s

Verify Highlight Detail Loaded
    Element Should Be Visible    ${COVER_IMAGE}
    Element Should Be Visible    ${TITLE}
    Element Should Be Visible    ${CREATION_INFO}
    Element Should Be Visible    ${DETAIL_TEXT}

Click Tag Link
    Scroll Element Into View    ${TAG_LINK}
    Sleep    1s
    ${current_url}=    Get Location
    Click Element    ${TAG_LINK}
    Sleep    3s
    ${new_url}=    Get Location
    Should Contain    ${new_url}    highlights/tag    msg=Expected URL to contain "highlights/tag"
    Go Back
    Sleep    2s

Click Gallery Image And Verify Modal
    Scroll Element Into View    ${GALLERY_IMAGE}
    Sleep    1s
    Click Element    ${GALLERY_IMAGE}
    Sleep    5s
    Wait Until Element Is Visible    ${IMAGE_MODAL_VISIBLE}    timeout=10s
    Element Should Be Visible    ${IMAGE_MODAL_VISIBLE}

Close Modal
    Click Element    ${MODAL_CLOSE_BUTTON}
    Sleep    2s

Close Browser Session
    Close Browser