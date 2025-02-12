*** Settings ***
Library    SeleniumLibrary

*** Variables ***
${BROWSER}    Chrome
${URL}    https://cs05sec267.cpkkuhost.com/
${ACTIVE_CAROUSEL}    xpath=//div[contains(@class, 'carousel-item active')]
${NEXT_BUTTON}    xpath=//button[@class='carousel-control-next']
${PREV_BUTTON}    xpath=//button[@class='carousel-control-prev']
${IMAGE}    //img[contains(@class, 'hl-image')]
${TITLE}    //a[contains(@class, 'author-name')]

*** Keywords ***
Open Web Page
    Open Browser    ${URL}    ${BROWSER}
    Maximize Browser Window
    Sleep    2s
    Wait Until Page Contains Element    ${IMAGE}    timeout=5s

Click Highlight Paper Image
    ${image}    Get WebElement    ${IMAGE}
    Click Element    ${image}
    Sleep    8s
    SeleniumLibrary.Location Should Be    ${URL}
    Go Back

Click Teacher Title
    ${teacher_link}    Get WebElement    ${TITLE}
    Click Element    ${teacher_link}
    Sleep    6s
    SeleniumLibrary.Location Should Be    ${URL}
    Go Back

Click Next Button
    Wait Until Element Is Visible    ${NEXT_BUTTON}    timeout=5s
    ${current_active}=    Get WebElement    ${ACTIVE_CAROUSEL}
    Click Button    ${NEXT_BUTTON}
    Sleep    3s  # รอให้ carousel เลื่อนไป
    ${new_active}=    Get WebElement    ${ACTIVE_CAROUSEL}
    Should Not Be Equal    ${current_active}    ${new_active}    Error: Next button did not change the slide!

Click Prev Button
    Wait Until Element Is Visible    ${PREV_BUTTON}    timeout=5s
    ${current_active}=    Get WebElement    ${ACTIVE_CAROUSEL}
    Click Button    ${PREV_BUTTON}
    Sleep    3s  # รอให้ carousel เลื่อนไป
    ${new_active}=    Get WebElement    ${ACTIVE_CAROUSEL}
    Should Not Be Equal    ${current_active}    ${new_active}    Error: Prev button did not change the slide!

Click Invalid Highlight Paper Image
    ${current_url}=    Get Location
    Click Element    ${IMAGE}
    Sleep    2s
    ${new_url}=    Get Location
    Should Be Equal    ${current_url}    ${new_url}    Error: Image click should not change URL

Click Invalid Author Name
    ${current_url}=    Get Location
    Click Element    ${NON_CLICKABLE_AUTHOR}
    Sleep    2s
    ${new_url}=    Get Location
    Should Be Equal    ${current_url}    ${new_url}    Error: Author name click should not change URL

Click Invalid Next Button
    ${current_active}=    Get WebElement    ${ACTIVE_CAROUSEL}
    Click Button    ${NEXT_BUTTON}
    Sleep    2s
    ${new_active}=    Get WebElement    ${ACTIVE_CAROUSEL}
    Should Be Equal    ${current_active}    ${new_active}    Error: Next button should not change the slide!

Click Invalid Prev Button
    ${current_active}=    Get WebElement    ${ACTIVE_CAROUSEL}
    Click Button    ${PREV_BUTTON}
    Sleep    2s
    ${new_active}=    Get WebElement    ${ACTIVE_CAROUSEL}
    Should Be Equal    ${current_active}    ${new_active}    Error: Prev button should not change the slide!
