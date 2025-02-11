*** Settings ***
Library    SeleniumLibrary

*** Variables ***
${BROWSER}    Chrome
${URL}    http://127.0.0.1:8000/
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
    ${image}    Get WebElement    ${IMAGE}
    Click Element    ${image}
    Sleep    2s  # รอเพื่อให้แน่ใจว่าไม่ได้ไปที่หน้าจริง
    ${current_url}=    Get Location
    Should Be Equal    ${current_url}    ${URL}    Error: Image click should not change URL

Click Invalid Teacher Title
    ${teacher_link}    Get WebElement    ${TITLE}
    Click Element    ${teacher_link}
    Sleep    2s  # รอเพื่อให้แน่ใจว่าไม่ได้ไปที่หน้าจริง
    ${current_url}=    Get Location
    Should Be Equal    ${current_url}    ${URL}    Error: Teacher title click should not change URL


Click Invalid Next Button
    Wait Until Element Is Visible    ${NEXT_BUTTON}    timeout=5s
    ${current_active}=    Get WebElement    ${ACTIVE_CAROUSEL}
    Click Button    ${NEXT_BUTTON}
    Sleep    2s  # รอให้ carousel เลื่อนไป
    ${new_active}=    Get WebElement    ${ACTIVE_CAROUSEL}
    Should Be Equal    ${current_active}    ${new_active}    Error: Next button should not have changed the slide!

Click Invalid Prev Button
    Wait Until Element Is Visible    ${PREV_BUTTON}    timeout=5s
    ${current_active}=    Get WebElement    ${ACTIVE_CAROUSEL}
    Click Button    ${PREV_BUTTON}
    Sleep    2s  # รอให้ carousel เลื่อนไป
    ${new_active}=    Get WebElement    ${ACTIVE_CAROUSEL}
    Should Be Equal    ${current_active}    ${new_active}    Error: Prev button should not have changed the slide!

