*** Settings ***
Documentation    A resource file for testing highlight banner in home page.
Library           SeleniumLibrary

*** Variables ***
${SERVER}            http://127.0.0.1:8000/
# ${SERVER}            http://cs05sec267.cpkkuhost.com
${BROWSER}           Chrome
${DELAY}             0.1s
${CAROUSEL_CONTAINER}       id=carouselExampleIndicators
${ACTIVE_SLIDE}             xpath=//div[@id="carouselExampleIndicators"]//div[contains(@class, "carousel-item active")]
${ACTIVE_LINK}              xpath=//div[@id="carouselExampleIndicators"]//div[contains(@class, "carousel-item active")]//a
${NEXT_BUTTON}              xpath=//button[contains(@class, "carousel-control-next")]
${PREV_BUTTON}              xpath=//button[contains(@class, "carousel-control-prev")]
${HIGHLIGHT_LINK}           xpath=//div[@id="carouselExampleIndicators"]//div[contains(@class, "carousel-item")]//a
${INVALID_HIGHLIGHT_LINK}   xpath=//a[@id="nonExistentHighlight"]
${INVALID_NEXT_BUTTON}      xpath=//button[@class="invalid-carousel-control-next"]
${INVALID_PREV_BUTTON}      xpath=//button[@class="invalid-carousel-control-prev"]

*** Keywords ***
Open Web Page
    Open Browser    ${SERVER}    ${BROWSER}
    Maximize Browser Window
    Sleep    2s
    Wait Until Page Contains Element    ${CAROUSEL_CONTAINER}    timeout=5s

Store Initial Active Slide
    [Documentation]    Store the id attribute of the active slide's link.
    ${initial_id}=    Get Element Attribute    ${ACTIVE_SLIDE}    id
    Set Suite Variable    ${INITIAL_ACTIVE_ID}    ${initial_id}

Active Slide Changed
    [Arguments]    ${initial_id}
    ${current_id}=    Get Element Attribute    ${ACTIVE_LINK}    id
    Should Not Be Equal    ${current_id}    ${initial_id}    Error: Next and Prev button did not change the slide!

Click Valid Highlight Link
    [Documentation]    Click the highlight link on the first slide and verify navigation.
    ${current_url}=    Get Location
    Click Element    ${HIGHLIGHT_LINK}
    Sleep    5s
    ${new_url}=    Get Location
    Should Contain    ${new_url}    highlightdetail    msg=Expected URL to contain "highlightdetail"
    Go Back
    Sleep    2s

Click Valid Next Button
    [Documentation]    Click the next button and verify the active slide changes.
    Wait Until Element Is Visible    ${NEXT_BUTTON}    timeout=5s
    Click Element    ${NEXT_BUTTON}
    Wait Until Keyword Succeeds    3 times    1s    Active Slide Changed    ${INITIAL_ACTIVE_ID}

Click Valid Prev Button
    [Documentation]    Click the previous button and verify the active slide changes.
    Wait Until Element Is Visible    ${PREV_BUTTON}    timeout=5s
    Click Element    ${PREV_BUTTON}
    Wait Until Keyword Succeeds    3 times    1s    Active Slide Changed    ${INITIAL_ACTIVE_ID}

Click Invalid Highlight Link
    [Documentation]    Attempt to click a non-existent highlight link and verify no navigation occurs.
    ${current_url}=    Get Location
    Run Keyword And Expect Error    *    Click Element    ${INVALID_HIGHLIGHT_LINK}
    ${new_url}=    Get Location
    Should Be Equal    ${current_url}    ${new_url}    Error: Invalid highlight link should not change URL

Click Invalid Next Button
    [Documentation]    Attempt to click an invalid next button and verify the active slide remains unchanged.
    ${current_id}=    Get Element Attribute    ${ACTIVE_LINK}    id
    Run Keyword And Expect Error    *    Click Button    ${INVALID_NEXT_BUTTON}
    ${new_id}=    Get Element Attribute    ${ACTIVE_LINK}    id
    Should Be Equal    ${current_id}    ${new_id}    Error: Invalid next button should not change the slide!

Click Invalid Prev Button
    [Documentation]    Attempt to click an invalid previous button and verify the active slide remains unchanged.
    ${current_id}=    Get Element Attribute    ${ACTIVE_LINK}    id
    Run Keyword And Expect Error    *    Click Button    ${INVALID_PREV_BUTTON}
    ${new_id}=    Get Element Attribute    ${ACTIVE_LINK}    id
    Should Be Equal    ${current_id}    ${new_id}    Error: Invalid prev button should not change the slide!

Close Browser Session
    Close Browser